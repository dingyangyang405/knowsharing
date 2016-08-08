<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MyKnowledgeController extends BaseController
{
    public function addCollectionAction(Request $request, $knowledgeId)
    {
/*        $user = $this->getCurrentUser();*/
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $knowledgeId
            );

        $hasCollected = $this->getUserService()->addUserCollect($fields);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function delCollectionAction(Request $request, $knowledgeId)
    {
        // $fields = array(
        //     'userId' => '1',
        //     'knowledgeId' => $knowledgeId
        //     );

    }

    public function addLikeAction(Request $request, $id)
    {
/*        $user = $this->getCurrentUser();*/
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $knowledgeId
            );

        $this->getUserService()->addUserLike($fields);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}