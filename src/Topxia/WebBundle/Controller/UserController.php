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
        $user = $this->getUserService()->getUser($id);

        $conditions = array(
            'userId' => $user['id'],
        );

        $knowledgeCount = $this->getKnowledgeService()->findKnowledgeCount($conditions);

        $collectionCount = $this->getCollectionService()->findCollectionCount($conditions);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'collectionCount' => $collectionCount
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

    protected function getCollectionService()
    {
        return $this->getServiceKernel('collection_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}