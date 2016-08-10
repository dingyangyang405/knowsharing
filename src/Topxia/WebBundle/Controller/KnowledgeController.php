<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Topxia\Common\ArrayToolKit;
use Topxia\Common\Paginator;

class KnowledgeController extends BaseController
{
    public function indexAction($id)
    {
        $knowledge = $this->getKnowledgeService()->get($id);
        $user = $this->getUserService()->get($knowledge['userId']);

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
            $commentUsers = $this->getUserService()->findByIds(array_unique($commentUserIds));
            foreach ($commentUsers as $commentUser) {
                $users[$commentUser['id']] = $commentUser;
            }
        }

        return $this->render('TopxiaWebBundle:Knowledge:index.html.twig',array(
            'knowledge' => $knowledge,
            'user' => $user,
            'comments' => $comments,
            'users' => $users,
            'paginator' => $paginator
        ));
    }

    public function addAction(Request $request)
    {
        $post = $request->request->all();
        $data = array(
            'title' => $post['title'],
            'summary' => $post['summary'],
            'content' => $post['content'],
            'type' => $post['type'],
            'userId' => 1,
        );
        $this->getKnowledgeService()->add($data);

        return new JsonResponse($data);
    }

    public function addCommentAction(Request $request)
    {
        // $user = 
        $data = $request->request->all();
        $params = array(
            'value' => $data['comment'],
            'userId' => 1,
            // 'userId' => $user['id'],
            'knowledgeId' => $data['knowledgeId']
        );
        $this->getKnowledgeService()->addComment($params);

        return new JsonResponse(ture);
    }

    public function favoriteAction(Request $request, $id)
    {
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $id
            );

        $this->getFavoriteService()->create($fields);
        $knowledge = $this->getKnowledgeService()->get($id);
        $knowledge['favoriteNum'] += 1; 
        $this->getKnowledgeService()->update($id, $knowledge);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function unfavoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->deleteByIdAndUserId($id, $userId);
        $knowledge = $this->getKnowledgeService()->get($id);
        $knowledge['favoriteNum'] = $knowledge['favoriteNum'] - 1; 
        $this->getKnowledgeService()->update($id, $knowledge);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function dislikeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->deleteByIdAndUserId($id, $userId);
        $knowledge = $this->getKnowledgeService()->get($id);
        $knowledge['likeNum'] = $knowledge['likeNum'] - 1; 
        $this->getKnowledgeService()->update($id, $knowledge);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function likeAction(Request $request, $id)
    {
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $id
            );

        $this->getLikeService()->create($fields);
        $knowledge = $this->getKnowledgeService()->get($id);
        $knowledge['likeNum'] += 1; 
        $this->getKnowledgeService()->update($id, $knowledge);
        return new JsonResponse(array(
            'status' => 'success'
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
}