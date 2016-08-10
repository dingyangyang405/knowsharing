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
        $knowledge = $this->getKnowledgeService()->find();

        $users = $this->getUserService()->findByIds(ArrayToolKit::column($knowledge, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge);

        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge);

        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledge' => $knowledge,
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
        return $this->biz['favorite_service'];
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }
}