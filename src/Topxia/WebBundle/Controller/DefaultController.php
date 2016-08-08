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
        $userKnowledges = $this->dealArrayKnowledges($knowledges);
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'userKnowledges' => $userKnowledges,
            ));
    }

    public function shareListAction(Request $request)
    {   
        $shareKnowledges = $this->getKnowledgeService()->getKnowledgesByUserId(1);

        return $this->render('TopxiaWebBundle:Default:knowledge-share.html.twig',array(
            'shareKnowledges' => $shareKnowledges
            ));
    }

    private function dealArrayKnowledges($knowledges)
    {
        $userKnowledges = array();
        foreach ($knowledges as $key => $knowledge) {
            $user = $this->getUserService()->getUser($knowledge['userId']);
            $collectonKnowledges = $this->getUserService()->findUserKnowledgesCollect();
            $likeKnowledges = $this->getUserService()->findUserKnowledgesLike();
            $knowledge['userName'] = $user['name'];
            $knowledge['likeNum'] = count($likeKnowledges);
            $knowledge['collectNum'] = count($collectonKnowledges );
            $userKnowledges[] = $knowledge;
        }
        return $userKnowledges;
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