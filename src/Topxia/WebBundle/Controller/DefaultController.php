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
        $userKnowledges = array();
        foreach ($knowledges as $key => $knowledge) {
            $user = $this->getUserService()->getUser($knowledge['ownerId']);
            $knowledge['userName'] = $user['name'];
            $userKnowledges[] = $knowledge;
        }
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'userKnowledges' => $userKnowledges
            ));
    }

    protected function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }
}