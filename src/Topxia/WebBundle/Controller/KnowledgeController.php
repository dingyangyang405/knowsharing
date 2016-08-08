<?php
namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class KnowledgeController extends BaseController
{
    public function detailAction($id)
    {
        $knowledge = $this->getKnowledgeService()->getKnowledgeDetial($id);
        $user = $this->getUserService()->getUser($knowledge['userId']);
        $comments = $this->getKnowledgeService()->searchComments($id);

        return $this->render('TopxiaWebBundle:Knowledge:detail.html.twig',array(
            'knowledge' => $knowledge,
            'user' => $user,
            'comments' => $comments
        ));
    }

    public function addKnowledgeAction(Request $request)
    {
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

    public function addCommentAction(Request $request)
    {
        // $user = 
        $data = $request->request->all();
        $params = array(
            'value' => $data['comment'],
            'userId' => 1,
            // 'userId' => $user['id'],
            'knowledgeId' => $data['knowledgeId']
        );
        $this->getKnowledgeService()->addComment($params);

        return new JsonResponse('ok');
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