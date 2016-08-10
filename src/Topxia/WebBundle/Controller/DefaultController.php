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
        return$this->biz['favorite_service'];
    }
}