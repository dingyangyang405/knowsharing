<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Common\TimeToolKit;
use Topxia\Common\ArrayToolKit;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {

        $knowledges = $this->getKnowledgeService()->findKnowledges();
        $knowledges = TimeToolKit::arrayToDetailTime($knowledges);
        $userIds = ArrayToolKit::column($knowledges,'ownerId');
        $users = $this->getUserService()->findUsersByIds($userIds);
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledges' => $knowledges
            ));
    }

    public function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    public function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}