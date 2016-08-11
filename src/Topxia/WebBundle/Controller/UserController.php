<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends BaseController
{
    public function indexAction(Request $request,$id)
    {
        $userId = 1;
        $user = $this->getUserService()->get(1);
        $hasfollowed = $this->getUserService()->getFollowObjectStatus(1,$id);
        $conditions = array(
            'userId' => $user['id'],
        );
        $knowledgeCount = $this->getKnowledgeService()->getKnowledgeCount($conditions);
        $favoriteCount = $this->getFavoriteService()->getFavoriteCount($conditions);

        $knowledge = $this->getKnowledgeService()->findKnowledgeByUserId($user['id']);
        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge,$userId);
        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge,$userId);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'favoriteCount' => $favoriteCount,
            'hasfollowed' => $hasfollowed,
            'knowledge' => $knowledge
        ));
    }

    public function followAction(Request $request, $id)
    {
        $this->getUserService()->followUser($id);

        return new JsonResponse(true);
    }

    public function unfollowAction(Request $request, $id)
    {
        $this->getUserService()->unfollowUser($id);

        return new JsonResponse(true);
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getFavoriteService()
    {
        return $this->biz['favorite_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }
}