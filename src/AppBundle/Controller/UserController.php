<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Biz\User\Impl\UserServiceImpl;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Common\ArrayToolKit;
use AppBundle\Common\Paginator;

class UserController extends BaseController
{
    public function indexAction(Request $request,$userId)
    {
        $currentUser = $this->getCurrentUser();
        $user = $this->getUserService()->getUser($userId);
        $hasfollowed = $this->getFollowService()->getFollowUserByUserIdAndObjectUserId($currentUser['id'],$userId);

        $conditions = array('userId' => $userId);
        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);
        $knowledgesCount = $this->getKnowledgeService()->getKnowledgesCount($conditions);

        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $knowledgesCount,
            20
        );
        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $knowledges = $this->getFavoriteService()->hasFavoritedKnowledge($knowledges,$userId);
        $knowledges = $this->getLikeService()->haslikedKnowledge($knowledges,$userId);

        return $this->render('AppBundle:User:index.html.twig', array(
            'user' => $user,
            'knowledgesCount' => $knowledgesCount,
            'favoritesCount' => $favoritesCount,
            'hasfollowed' => $hasfollowed,
            'knowledges' => $knowledges,
            'paginator' => $paginator
        ));
    }

    public function listFavoritesAction(Request $request, $userId)
    {
        $currentUser = $this->getCurrentUser();
        $user = $this->getUserService()->getUser($userId);
        $hasfollowed = $this->getFollowService()->getFollowUserByUserIdAndObjectUserId($currentUser['id'],$userId);
        
        $conditions = array('userId' => $userId);
        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);
        $knowledgesCount = $this->getKnowledgeService()->getKnowledgesCount($conditions);
        $favorites = $this->getFavoriteService()->findFavoritesByUserId($userId);
        $knowledgeIds = ArrayToolKit::column($favorites,'knowledgeId');

        $paginator = new Paginator(
            $this->get('request'),
            $favoritesCount,
            20
        );
        $knowledges = $this->getKnowledgeService()->searchKnowledgesByIds(
            $knowledgeIds,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');

        return $this->render('AppBundle:User:favorite.html.twig', array(
            'users' => $users,
            'user' => $user,
            'knowledgesCount' => $knowledgesCount,
            'favoritesCount' => $favoritesCount,
            'hasfollowed' => $hasfollowed,
            'knowledges' => $knowledges,
            'paginator' => $paginator
        ));
    }

    public function myFavoritesAction(Request $request)
    {
        $currentUser = $this->getCurrentUser();
        if (!$currentUser->isLogin()) {
           return $this->redirect($this->generateUrl("login"));
        }
        $favorites = $this->getFavoriteService()->findFavoritesByUserId($currentUser['id']);
        $knowledgeIds = ArrayToolKit::column($favorites,'knowledgeId');

        $conditions = array('knowledgeIds' => $knowledgeIds);
        $orderBy = array('createdTime', 'DESC');
        $paginator = new Paginator(
            $this->get('request'),
            $this->getKnowledgeService()->getKnowledgesCount($conditions),
            20
        );
        $knowledges = $this->getKnowledgeService()->searchKnowledges(
            $conditions,
            $orderBy,
            $paginator->getOffsetCount(),
            $paginator->getPerPageCount()
        );

        $users = $this->getUserService()->findUsersByIds(ArrayToolKit::column($knowledges, 'userId'));
        $users = ArrayToolKit::index($users, 'id');
        return $this->render('AppBundle:MyKnowledgeShare:my-favorites.html.twig', array(
            'knowledges' => $knowledges,
            'users' => $users,
            'paginator' => $paginator,
            'type' => 'myFavorite'
        ));
    }

    public function listFollowsAction(Request $request, $userId, $type)
    {   
        $currentUser = $this->getCurrentUser();
        $user = $this->getUserService()->getUser($userId);
        $conditions = array('userId' => $user['id']);
        $knowledgesCount = $this->getKnowledgeService()->getKnowledgesCount($conditions);
        $favoritesCount = $this->getFavoriteService()->getFavoritesCount($conditions);
        $hasfollowed = $this->getFollowService()->getFollowUserByUserIdAndObjectUserId($currentUser['id'],$userId);

        $follows = $this->getFollowService()->searchMyFollowsByUserIdAndType($userId, $type);
        $objectIds = ArrayToolKit::column($follows,'objectId');
        if ($type == 'user') {
            $paginator = new Paginator(
                $this->get('request'),
                count($objectIds),
                20
            );
            $objects = $this->getUserService()->searchUsers(
                $objectIds,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );

            $objects = $this->getFollowService()->hasFollowUsers($objects,$currentUser['id']);
        } elseif ($type == 'topic') {
            $conditions = array('ids' => $objectIds);
            $orderBy = array('createdTime', 'DESC');

            $paginator = new Paginator(
                $this->get('request'),
                count($objectIds),
                20
            );
            $objects = $this->getTopicService()->searchTopics(
                $conditions,
                $orderBy,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );

            $objects = $this->getFollowService()->hasFollowTopics($objects,$currentUser['id']);
        }

        return $this->render('AppBundle:User:follows.html.twig', array(
            'objects' => $objects,
            'type' => $type,
            'knowledgesCount' => $knowledgesCount,
            'favoritesCount' => $favoritesCount,
            'hasfollowed' => $hasfollowed,
            'user' => $user,
            'paginator' => $paginator
        ));
    }

    public function myFollowsAction(Request $request, $type)
    {
        $currentUser = $this->getCurrentUser();
        if (!$currentUser->isLogin()) {
           return $this->redirect($this->generateUrl("login"));
        }
        $myFollows = $this->getFollowService()->searchMyFollowsByUserIdAndType($currentUser['id'], $type);
        $objectIds = ArrayToolKit::column($myFollows,'objectId');
        if ($type == 'user') {
            $paginator = new Paginator(
                $this->get('request'),
                count($objectIds),
                20
            );
            $objects = $this->getUserService()->searchUsers(
                $objectIds,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );
            $objects = $this->getFollowService()->hasFollowUsers($objects,$currentUser['id']);
        } elseif ($type == 'topic') {
            $conditions = array('ids' => $objectIds);
            $orderBy = array('createdTime', 'DESC');

            $paginator = new Paginator(
                $this->get('request'),
                count($objectIds),
                20
            );
            $objects = $this->getTopicService()->searchTopics(
                $conditions,
                $orderBy,
                $paginator->getOffsetCount(),
                $paginator->getPerPageCount()
            );
            $objects = $this->getFollowService()->hasFollowTopics($objects,$currentUser['id']);
        }

        return $this->render('AppBundle:MyKnowledgeShare:my-follows.html.twig', array(
            'objects' => $objects,
            'type' => $type,
            'paginator' => $paginator
        ));
    }

    public function followAction(Request $request, $id)
    {   
        $currentUser = $this->getCurrentUser(); 
        if (empty($currentUser)) {
            throw new \Exception('用户不存在');
        }
        $this->getFollowService()->followUser($currentUser['id'], $id);

        return new JsonResponse(true);
    }

    public function unfollowAction(Request $request, $id)
    {   
        $currentUser = $this->getCurrentUser(); 
        if (empty($currentUser)) {
            throw new \Exception('用户不存在');
        }
        $this->getFollowService()->unfollowUser($currentUser['id'], $id);

        return new JsonResponse(true);
    }

    public function createToreadAction(Request $request, $id)
    {
        $user = $this->getCurrentUser();

        if (empty($user)) {
            throw new \Exception('用户不存在');
        }

        $this->getToreadService()->createToreadKnowledge($id ,$user['id']);

        return new JsonResponse(true);
    }

    public function deleteToreadAction(Request $request, $id)
    {
        $user = $this->getCurrentUser();

        if (empty($user)) {
            throw new \Exception('用户不存在');
        }

        $this->getToreadService()->deleteToreadKnowledge($id, $user['id']);

        return new JsonResponse(true);
    }

    protected function getKnowledgeService()
    {
        return $this->biz['knowledge_service'];
    }

    protected function getTopicService()
    {
        return $this->biz['topic_service'];
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

    protected function getFollowService()
    {
        return $this->biz['follow_service'];
    }

    protected function getToreadService()
    {
        return $this->biz['toread_service'];
    }
}