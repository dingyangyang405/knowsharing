<?php

namespace Topxia\WebBundle\Controller;

use Topxia\Common\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MyKnowledgeShareController extends BaseController
{
    public function indexAction(Request $request)
    {   
        // $userId = $this->getUserService()->getCurrentUser();
        $userId = 1;
        $conditions = array('userId' => $userId);

        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->searchKnowledgeCount($conditions),
            10
        );

        $shareKnowledge = $this->getKnowledgeService()->searchAllKnowledge(
            $conditions,
            array('createdTime', 'DESC'),
            $paginator->getOffsetCount(), 
            $paginator->getPerPageCount()
        );
        
        return $this->render('TopxiaWebBundle:MyKnowledgeShare:my-knowledge.html.twig',array(
            'shareKnowledge' => $shareKnowledge,
            'paginator' => $paginator
        ));
    }

    public function editAction(Request $request, $id)
    {
        $knowledge = $this->getKnowledgeService()->getKnowledge($id);
        if ($request->getMethod() == 'POST') {
            $knowledge = $request->request->all();
            $this->getKnowledgeService()->update($id, $knowledge);

            return $this->redirect($this->generateUrl('
                my_knowledge_share'));
        }

        return $this->render('TopxiaWebBundle:MyKnowledgeShare:edit-knowledge.html.twig', array(
            'knowledge' => $knowledge
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $this->getKnowledgeService()->delete($id);

        return new JsonResponse(true);
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }
}
