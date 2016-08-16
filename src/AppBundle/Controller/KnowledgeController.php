<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolKit;
use AppBundle\Common\Paginator;

class KnowledgeController extends BaseController
{
    public function indexAction($id)
    {
        $currentUser = $this->biz->getUser();
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $hasLearned = $this->getLearnService()->getLearnedByIdAndUserId($id, $currentUser['id']);

        $user = $this->getUserService()->getUser($knowledge['userId']);

        $conditions = array('knowledgeId' => $knowledge['id']);
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->getCommentsCount($conditions),
            20
        );
        $comments = $this->getKnowledgeService()->searchComments(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = array();
        if (!empty($comments)) {
            $commentUserIds = ArrayToolKit::column($comments, 'userId');
            $commentUsers = $this->getUserService()->findUsersByIds(array_unique($commentUserIds));
            foreach ($commentUsers as $commentUser) {
                $users[$commentUser['id']] = $commentUser;
            }
        }

        $knowledge = array($knowledge);
        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge,$currentUser['id']);
        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge,$currentUser['id']);

        return $this->render('AppBundle:Knowledge:index.html.twig',array(
            'knowledge' => $knowledge[0],
            'user' => $user,
            'comments' => $comments,
            'users' => $users,
            'paginator' => $paginator,
            'hasLearned' => $hasLearned
        ));
    }

    public function createKnowledgeAction(Request $request)
    {
        $user = $this->biz->getUser();
        $post = $request->request->all();
        if ($post['type'] == 'file') {
            $content = $request->files->get('content');
        } else {
            $content = $request->request->get('content');            
        }
        // $path = $this->getKnowledgeService()->getPath($file);
        $topic = $this->getTopicService()->getTopicById($post['topic'] ,$user);
        $data = array(
            'title' => $post['title'],
            'summary' => $post['summary'],
            'content' => $content,
            'topicId' => $topic['id'],
            'type' => $post['type'],
            'userId' => $user['id'],
        );
        $this->getKnowledgeService()->createKnowledge($data);
        $this->getUserService()->addScore($user['id'], 3);

        return new JsonResponse($data);
    }

    public function createCommentAction(Request $request)
    {
        $currentUser = $this->biz->getUser(); 

        $data = $request->request->all();
        $params = array(
            'value' => $data['comment'],
            'userId' => $currentUser['id'],
            'knowledgeId' => $data['knowledgeId']
        );
        $this->getKnowledgeService()->createComment($params);
        $knowledge = $this->getKnowledgeService()->getKnowledge($data['knowledgeId']);
        $this->getUserService()->addScore($currentUser['id'], 2);
        $this->getUserService()->addScore($knowledge['userId'], 3);

        return new JsonResponse(ture);
    }

    public function favoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->favoriteKnowledge($id, $userId);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($userId, 1);
        $this->getUserService()->addScore($knowledge['userId'], 5);

        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function unfavoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->unfavoriteKnowledge($id, $userId);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->minusScore($userId, -1);
        $this->getUserService()->minusScore($knowledge['userId'], -5);

        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function dislikeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->dislikeKnowledge($id, $userId);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->minusScore($userId, -1);
        $this->getUserService()->minusScore($knowledge['userId'], -2);

        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function likeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->likeKnowledge($id, $userId);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($userId, 1);
        $this->getUserService()->addScore($knowledge['userId'], 2);

        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function finishLearnAction(Request $request, $id)
    {
        $currentUser = $this->biz->getUser();
        $this->getLearnService()->finishKnowledgeLearn($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($currentUser['id'], 1);
        $this->getUserService()->addScore($knowledge['userId'], 1);

        return new JsonResponse(array(
            'status'=>'success'
        ));
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
    }

    protected function getFavoriteService()
    {
        return $this->biz['favorite_service'];
    }

    protected function getFollowTopicService()
    {
        return $this->biz['follow_topic_service'];
    }

    protected function getLearnService()
    {
        return $this->biz['learn_service'];
    }
}