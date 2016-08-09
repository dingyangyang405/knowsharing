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
        $shareKnowledge = $this->getKnowledgeService()->findKnowledgeByUserId(1);

        return $this->render('TopxiaWebBundle:Default:my-knowledge.html.twig',array(
            'shareKnowledge' => $shareKnowledge
        ));
    }

    private function dealArrayKnowledges($knowledges)
    {
        $userKnowledges = array();
        foreach ($knowledges as $key => $knowledge) {
            $user = $this->getUserService()->get($knowledge['userId']);
            $collectonKnowledges = $this->getUserService()->findUserCollectByKnowledgeId($knowledge['id']);
            $likeKnowledges = $this->getUserService()->findUserLikeByKnowledgeId($knowledge['id']);
            $knowledge['hasCollected'] = $this->getUserService()->getCollectByUserAndKnowledgeId('1',$knowledge['id']);
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