<?php
namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Topxia\Common\ArrayToolKit;

class KnowledgeController extends BaseController
{
    public function indexAction($id)
    {
        $knowledge = $this->getKnowledgeService()->get($id);
        $user = $this->getUserService()->get($knowledge['userId']);

        $conditions = array('knowledgeId' => $knowledge['id']);
        $orderBy = array('createdTime', 'DESC');
        // $paginator = new Paginator(
        //     $this->get('request'),
        //     $this->getKnowledgeService()->getCommentsCount($id),
        //     20
        // );
        $comments = $this->getKnowledgeService()->searchComments(
            $conditions,
            $orderBy,
            0,
            PHP_INT_MAX
        );
        $commentUserIds = ArrayToolKit::column($comments, 'userId');
        $commentUsers = $this->getUserService()->findUsersByIds(array_unique($commentUserIds));

        return $this->render('TopxiaWebBundle:Knowledge:index.html.twig',array(
            'knowledge' => $knowledge,
            'user' => $user,
            'comments' => $comments,
            'commentUsers' => $commentUsers
        ));
    }

    public function addAction(Request $request)
    {
        $post = $request->request->all();
        $data = array(
            'title' => $post['title'],
            'summary' => $post['summary'],
            'content' => $post['content'],
            'type' => $post['type'],
            'userId' => 1,
        );
        $this->getKnowledgeService()->add($data);

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

        return new JsonResponse(ture);
    }

    public function favoriteAction(Request $request, $id)
    {
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $id
            );

        $this->getFavoriteService()->create($fields);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    public function unfavoriteAction(Request $request, $id)
    {
        $userId = '1';
        $this->getFavoriteService()->deleteByIdAndUserId($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function dislikeAction(Request $request, $id)
    {
        $userId = '1';
        $this->getLikeService()->deleteByIdAndUserId($id, $userId);
        return new JsonResponse(array(
            'status' => 'success'
        ));

    }

    public function likeAction(Request $request, $id)
    {
/*        $user = $this->getCurrentUser();*/
        $fields = array(
            'userId' => '1',
            'knowledgeId' => $knowledgeId
            );

        $this->getLikeService()->create($fields);
        return new JsonResponse(array(
            'status' => 'success'
        ));
    }

    protected function getLikeService()
    {
        return $this->getServiceKernel('like_service');
    }

    protected function getKnowledgeService()
    {
        return $this->getServiceKernel('knowledge_service');
    }

    protected function getUserService()
    {
        return $this->getServiceKernel('user_service');
    }

    protected function getFavoriteService()
    {
        return $this->getServiceKernel('favorite_service');
    }   
}