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
        $user = $this->getUserService()->getUser($id);
        $hasfollowed = $this->getUserService()->getFollowUserByUserIdAndObjectUserId(1,$id);
        $conditions = array(
            'userId' => $user['id'],
        );
        $knowledgesCount = $this->getKnowledgeService()->getKnowledgesCount($conditions);
        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);

        $knowledges = $this->getKnowledgeService()->findKnowledgesByUserId($user['id']);
        $knowledges = $this->getFavoriteService()->hasFavoritedKnowledge($knowledges,$id);
        $knowledges = $this->getLikeService()->haslikedKnowledge($knowledges,$id);

        return $this->render('TopxiaWebBundle:User:index.html.twig',array(
            'user' => $user,
            'knowledgesCount' => $knowledgesCount,
            'favoritesCount' => $favoritesCount,
            'hasfollowed' => $hasfollowed,
            'knowledges' => $knowledges
        ));
    }

    public function listFavoriteAction(Request $request, $userId)
    {
        $userId = 1;
        $user = $this->getUserService()->getUser(1);
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
            'knowledgesCount' => $knowledgesCount,
            'favoritesCount' => $favoritesCount,
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