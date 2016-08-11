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
        $knowledges = $this->getKnowledgeService()->findKnowledges();

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        $knowledges = $this->getFavoriteService()->hasFavoritedKnowledge($knowledges,$userId);

        $knowledges = $this->getLikeService()->haslikedKnowledge($knowledges,$userId);
        // var_dump($users);
        // exit();
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'knowledges' => $knowledges,
            'users' => $users
        ));
    }

    public function shareListAction(Request $request)
    {   
        $knowledges = $this->getKnowledgeService()->findKnowledgesByUserId(1);

        return $this->render('TopxiaWebBundle:Default:my-knowledge.html.twig',array(
            'knowledges' => $knowledges
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