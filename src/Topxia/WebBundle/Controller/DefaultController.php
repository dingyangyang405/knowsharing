<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Common\ArrayToolKit;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {
        $userId = '1';
        $knowledges = $this->getKnowledgeService()->find();

        $users = $this->getUserService()->findByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        $knowledges = $this->getFavoriteService()->hasFavoritedKnowledge($knowledges);

        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledges' => $knowledges,
            'users' => $users
        ));
    }

    public function shareListAction(Request $request)
    {   
        $shareKnowledge = $this->getKnowledgeService()->findKnowledgeByUserId(1);

        return $this->render('TopxiaWebBundle:Default:my-knowledge.html.twig',array(
            'shareKnowledge' => $shareKnowledge
        ));
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getFavoriteService()
    {
        return$this->getServiceKernel('favorite_service');
    }
}