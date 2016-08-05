<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;

class UserController extends BaseController
{
    public function indexAction(Request $request)
    {

        $user = $this->getUserService()->getUser(1);

        $knowledgeCount = $this->getKnowledgeService()->findKnowledgeCount(array('ownerId' => $user['id']));

        // $collectionCount = $this->getCollectionService()->findCollectionCount($user['id']);

        // var_dump($knowledgeCount);exit;

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'collectionCount' => $collectionCount
        ));
    }

    protected function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    protected function getCollectionService()
    {
        return $this->getServiceKernel('collection_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}