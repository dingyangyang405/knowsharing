<?php
namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class KnowledgeController extends BaseController
{
    public function detailAction($id)
    {
        $konwledge = $this->getKnowledgeService()->getKnowledgeDetial($id);
        return $this->render('TopxiaWebBundle:Knowledge:detail.html.twig',array(
            'konwledge' => $konwledge
        ));
    }
    
    protected function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    public function addlinkAction(Request $request){
        $data = $request->request->all();
        $this->getKnowledgeService()->addKnowledge($data);
        return new JsonResponse($data);
    }
}