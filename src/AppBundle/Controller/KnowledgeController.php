<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Common\ArrayToolKit;
use AppBundle\Common\Paginator;

class KnowledgeController extends BaseController
{
    public function indexAction($id)
    {
        $currentUser = $this->getCurrentUser();

        if (in_array('ROLE_SUPER_ADMIN', $currentUser['roles'])) {
            $userRole = array(
                'roles' => 'admin'
            );
        } else {
            $userRole = array(
                'roles' => 'user'
            );
        }

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
            'userRole' => $userRole,
            'comments' => $comments,
            'users' => $users,
            'paginator' => $paginator,
            'hasLearned' => $hasLearned
        ));
    }

    public function createKnowledgeAction(Request $request)
    {
        $user = $this->getCurrentUser();
        $post = $request->request->all();
        if ($post['type'] == 'file') {
            $file = $request->files->get('content');
            $content = $this->getKnowledgeService()->moveToPath($file,$user,$post['title']);   
        } elseif ($post['type'] == 'link') {
            $content = $request->request->get('content');        
        }

        $topic = $this->getTopicService()->getTopicById($post['topic'],$user);
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

    public function adminEditAction(Request $request, $id)
    {
        if ($request->getMethod() == "POST") {
            $knowledge = $request->request->all();
            $this->getKnowledgeService->updateKnowledge($id, $knowledge);

            return $this->redirect($this->generateUrl('homepage'));
        }
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);

        return $this->render('AppBundle:Knowledge:admin-edit.html.twig', array('knowledge' => $knowledge
        ));
    }

    public function adminDeleteAction(Request $request, $id)
    {   
        $this->getKnowledgeService()->deleteKnowledge($id);
        
        return new JsonResponse(true); 
    }

    public function createCommentAction(Request $request)
    {
        $currentUser = $this->getCurrentUser(); 
        if (!$currentUser->isLogin()) {
           return new JsonResponse(false);
        }
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
        $currentUser = $this->getCurrentUser();
        $this->getFavoriteService()->favoriteKnowledge($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($currentUser['id'], 1);
        $this->getUserService()->addScore($knowledge['userId'], 5);

        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function unfavoriteAction(Request $request, $id)
    {
        $currentUser = $this->getCurrentUser();
        $this->getFavoriteService()->unfavoriteKnowledge($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->minusScore($currentUser['id'], -1);
        $this->getUserService()->minusScore($knowledge['userId'], -5);

        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function dislikeAction(Request $request, $id)
    {
        $currentUser = $this->getCurrentUser();
        $this->getLikeService()->dislikeKnowledge($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->minusScore($currentUser['id'], -1);
        $this->getUserService()->minusScore($knowledge['userId'], -2);

        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function likeAction(Request $request, $id)
    {
        $currentUser = $this->getCurrentUser();
        $this->getLikeService()->likeKnowledge($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($currentUser['id'], 1);
        $this->getUserService()->addScore($knowledge['userId'], 2);

        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function finishLearnAction(Request $request, $id)
    {
        $currentUser = $this->getCurrentUser();
        if (!$currentUser->isLogin()) {
           return new JsonResponse(array(
            'status'=>'false'
        ));
        }
        $this->getLearnService()->finishKnowledgeLearn($id, $currentUser['id']);
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $this->getUserService()->addScore($currentUser['id'], 1);
        $this->getUserService()->addScore($knowledge['userId'], 1);

        return new JsonResponse(array(
            'status'=>'success'
        ));
    }

    public function downloadFileAction(Request $request, $id)
    {
        $currentUser = $this->getCurrentUser();
        if (!$currentUser->isLogin()) {
           return $this->redirect($this->generateUrl("login"));;
        }
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        $auth = $this->getUserService()->getUser($knowledge['userId']);

        $fileName = substr($knowledge['content'],0);
        $filePath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$auth['username'].'/'.$fileName;
        $fopen = fopen($filePath,"r+");

        if (!file_exists($filePath)) {
            throw new \Exception("文件不存在");
        }

        $content = fread($fopen, filesize($filePath));

        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');
        $response->setContent($content);
        fclose($fopen);
        return $response;
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