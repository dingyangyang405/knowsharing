<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;

class UserController extends BaseController
{
    public function indexAction(Request $request)
    {

        $user = $this->getUserService()->get(1);

        $conditions = array(
            'userId' => $user['id'],
        );

        $knowledgeCount = $this->getKnowledgeService()->getKnowledgeCount($conditions);

        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'favoritesCount' => $favoriteCount
        ));
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