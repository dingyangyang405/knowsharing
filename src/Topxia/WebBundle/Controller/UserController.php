<?php

namespace Topxia\WebBundle\Controller;

use Topxia\WebBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Topxia\Service\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends BaseController
{
    public function indexAction(Request $request,$id)
    {
        $userId = 1;
        $user = $this->getUserService()->get(1);
        $hasfollowed = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,$id);
        $conditions = array(
            'userId' => $user['id'],
        );
        $knowledgeCount = $this->getKnowledgeService()->getKnowledgeCount($conditions);
        $favoriteCount = $this->getFavoriteService()->getFavoriteCount($conditions);

        $knowledge = $this->getKnowledgeService()->findKnowledgeByUserId($user['id']);
        $knowledge = $this->getFavoriteService()->hasFavoritedKnowledge($knowledge,$userId);
        $knowledge = $this->getLikeService()->haslikedKnowledge($knowledge,$userId);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'favoriteCount' => $favoriteCount,
            'hasfollowed' => $hasfollowed,
            'knowledge' => $knowledge
        ));
    }

    public function listFavoriteAction(Request $request, $userId)
    {
        $userId = 1;
        $user = $this->getUserService()->get(1);
        $conditions = array(
            'userId' => $user['id'],
        );

        $favorites = $this->getFavoriteService()->findFavoritesByUserId($userId);
        foreach ($favorites as $key => $favorite) {
            $knowledges[] = $this->getKnowledgeService()->get($favorite['knowledgeId']);
        }
        $hasfollowed = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,$userId);

        $knowledgeCount = $this->getKnowledgeService()->getKnowledgeCount($conditions);
        $favoriteCount = $this->getFavoriteService()->getFavoriteCount($conditions);

        return $this->render('TopxiaWebBundle:User:favorite.html.twig',array(
            'user' => $user,
            'knowledgeCount' => $knowledgeCount,
            'favoriteCount' => $favoriteCount,
            'hasfollowed' => $hasfollowed,
            'favorites' => $favorites,
            'knowledges' => $knowledges
        ));
    }

    public function followAction(Request $request, $id)
    {
        $this->getUserService()->followUser($id);

        return new JsonResponse(true);
    }

    public function unfollowAction(Request $request, $id)
    {
        $this->getUserService()->unfollowUser($id);

        return new JsonResponse(true);
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getFavoriteService()
    {
        return $this->biz['favorite_service'];
    }

    protected function getUserService()
    {
        return $this->biz['user_service'];
    }

    protected function getLikeService()
    {
        return $this->biz['like_service'];
    }
}