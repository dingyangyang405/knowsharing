<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends BaseController
{
    public function indexAction(Request $request)
    {

        $konwledges = $this->getKnowledgeService()->findKnowledges();
        return $this->render('TopxiaWebBundle:Default:index.html.twig',array(
            'konwledges' => $konwledges
            ));
    }

    public function addlinkAction(Request $request){
        $data = $request->request->all();
        $this->getKnowledgeService()->addKnowledge($data);
        return new JsonResponse($data);
    }

    public function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }
}