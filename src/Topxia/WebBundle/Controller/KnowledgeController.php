<?php
namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class KnowledgeController extends BaseController
{
    public function detailAction($id)
    {
        $konwledge = $this->getKnowledgeService()->getKnowledgeDetial($id);
        $user = $this->getUserService()->getUser($konwledge['userId']);

        return $this->render('TopxiaWebBundle:Knowledge:detail.html.twig',array(
            'konwledge' => $konwledge,
            'user' => $user,
        ));
    }

    public function addKnowledgeAction(Request $request){
        $post = $request->request->all();
        $data = array(
            'title' => $post['title'],
            'summary' => $post['summary'],
            'content' => $post['content'],
            'type' => $post['type'],
            'userId' => 1,
        );
        $this->getKnowledgeService()->addKnowledge($data);

        return new JsonResponse($data);
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