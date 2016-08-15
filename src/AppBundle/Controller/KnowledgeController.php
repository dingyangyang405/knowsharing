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
        $userId = 1;
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $hasLearned = $this->getLearnService()->getLearnedByIdAndUserId($id, $userId);

        $user = $this->getUserService()->getUser($knowledge['userId']);

        $conditions = array('knowledgeId' => $knowledge['id']);
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->getCommentsCount($conditions),
            10
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
        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge,$userId);
        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge,$userId);

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
        $post = $request->request->all();
        $data = array(
            'title' => $post['title'],
            'summary' => $post['summary'],
            'content' => $post['content'],
            'type' => $post['type'],
            'userId' => 1,
        );
        $this->getKnowledgeService()->createKnowledge($data);

        return new JsonResponse($data);
    }

    public function createCommentAction(Request $request)
    {
        // $user = 
        $data = $request->request->all();
        $params = array(
            'value' => $data['comment'],
            'userId' => 1,
            // 'userId' => $user['id'],
            'knowledgeId' => $data['knowledgeId']
        );
        $this->getKnowledgeService()->createComment($params);

        return new JsonResponse(ture);
    }

    public function favoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->favoriteKnowledge($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function unfavoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->unfavoriteKnowledge($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function dislikeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->dislikeKnowledge($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function likeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->likeKnowledge($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function finishLearnAction(Request $request, $id)
    {
        $userId = '2';
        $this->getLearnService()->finishKnowledgeLearn($id, $userId);
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