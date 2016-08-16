<?php

namespace AppBundle\Controller;

use AppBundle\Common\Paginator;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolKit;

class MyKnowledgeShareController extends BaseController
{
    public function indexAction(Request $request)
    {   
        $user = $this->biz->getUser();
        $fields = $request->query->all();
        $conditions = array(
            'userId' => $user['id'],
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
        
        return $this->render('AppBundle:MyKnowledgeShare:my-knowledge.html.twig',array(
            'knowledges' => $knowledges,
            'paginator' => $paginator
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

        return $this->render('AppBundle:MyKnowledgeShare:edit-knowledge.html.twig', array(
            'knowledge' => $knowledge
        ));
    }

    public function toDoListAction(Request $request)
    {
        $user = $this->biz->getUser();
        $toDoList = $this->getToDoListService()->findToDoListByUserId($user['id']);

        $paginator = new Paginator(
            $request,
            count($toDoList),
            20
        );

        $ids = ArrayToolKit::column($toDoList, 'knowledgeId');

        $knowledges = $this->getKnowledgeService()->searchKnowledgesByIds(
            $ids,
            $paginator->getOffsetCount(), 
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        return $this->render('AppBundle:MyKnowledgeShare:knowledge-todolist.html.twig', array(
            'knowledges' => $knowledges,
            'users' => $users,
            'paginator' => $paginator
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $this->getKnowledgeService()->deleteKnowledge($id);

        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getToDoListService()
    {
        return $this->biz['todolist_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }
}
