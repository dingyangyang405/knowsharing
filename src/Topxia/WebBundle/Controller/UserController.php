<?php

namespace Topxia\WebBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;

class UserController extends BaseController
{
    public function indexAction(Request $request)
    {

        $user = $this->getUserService()->getUser(1);

        $knowledgeCount = $this->getKnowledgeService()->findKnowledgeCount($user['id']);

        $collectionCount = $this->getCollectionService()->findCollectionCount($user['id']);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'collectionCount' => $collectionCount
        ));
    }

    public function getUserService()
    {
        $container = $this->container->get('biz_kernel');
        return $container['user_service'];
    }
}