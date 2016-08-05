<?php
namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class KnowledgeController extends BaseController
{
    public function detailAction($id)
    {
        $konwledge = $this->getKnowledgeService()->getKnowledgeDetial($id);
        $user = $this->getUserService()->getUser($konwledge['id']);
        return $this->render('TopxiaWebBundle:Knowledge:detail.html.twig',array(
            'konwledge' => $konwledge,
            'user' => $user
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