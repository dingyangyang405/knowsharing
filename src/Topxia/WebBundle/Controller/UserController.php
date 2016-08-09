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
        $user = $this->getUserService()->get(1);
        $hasfollowed = $this->getUserService()->getFollowObjectStatus(1,$id);
        $conditions = array(
            'userId' => $user['id'],
        );

        $knowledgeCount = $this->getKnowledgeService()->getKnowledgeCount($conditions);

        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'favoritesCount' => $favoriteCount,
            'hasfollowed' => $hasfollowed
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
        return $this->getServiceKernel('knowledge_service');
    }

    protected function getFavoriteService()
    {
        return $this->getServiceKernel('favorite_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}