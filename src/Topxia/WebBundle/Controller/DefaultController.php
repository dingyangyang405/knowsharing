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

        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge,$userId);

        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge,$userId);

        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledge' => $knowledge,
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

    public function docModalAction(Request $request)
    {
        return $this->render('TopxiaWebBundle::add-file.html.twig');
    }

    public function linkModalAction(Request $request)
    {
        return $this->render('TopxiaWebBundle::add-link.html.twig');
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