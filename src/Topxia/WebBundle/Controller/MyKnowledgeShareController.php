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
        $fields = $request->query->all();
        $conditions = array(
            'userId' => $userId,
            'keyword' => '',
        );

        $conditions = array_merge($conditions, $fields);
        if (isset($conditions['keyword'])) {
            $conditions['title'] = "%{$conditions['keyword']}%";
            unset($conditions['keyword']);
        }

        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->getKnowledgesCount($conditions),
            20
        );

        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $conditions,
            array('createdTime', 'DESC'),
            $paginator->getOffsetCount(), 
            $paginator->getPerPageCount()
        );
        
        return $this->render('TopxiaWebBundle:MyKnowledgeShare:my-knowledge.html.twig',array(
            'knowledges' => $knowledges,
            'paginator' => $paginator,
        ));
    }

    public function editAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $knowledge = $request->request->all();
            $this->getKnowledgeService()->updateKnowledge($id, $knowledge);

            return $this->redirect($this->generateUrl('my_knowledge_share'));
        }

        $knowledge = $this->getKnowledgeService()->getKnowledge($id);

        return $this->render('TopxiaWebBundle:MyKnowledgeShare:edit-knowledge.html.twig', array(
            'knowledge' => $knowledge
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $this->getKnowledgeService()->deleteKnowledge($id);

        return new JsonResponse(true);
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }
}
