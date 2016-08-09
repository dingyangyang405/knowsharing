<?php
namespace Topxia\Service\User\Impl;

use Topxia\Service\User\UserService;

class UserServiceImpl implements UserService
{
    protected  $container;

    public  function __construct($container)
    {
        $this->container = $container;
    }

    public function getUser($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function findUsersByIds($ids)
    {
        return $this->getUserDao()->findByIds($ids);
    }

    public function findUserLikeByKnowledgeId($id)
    {
        return $this->getUserLikeDao()->findUserLikeByKnowledgeId($id);
    }

    public function addUserCollect($fields)
    {
        return $this->getUserCollectDao()->create($fields);
    }

    public function delUserCollect($fields)
    {
        return $this->getUserCollectDao()->delete($fields);
    }

    public function addUserLike($fields)
    {
        return $this->getUserLikeDao()->create($fields);
    }

    public function findUserCollectByKnowledgeId($id)
    {
        return $this->getUserCollectDao()->findUserCollectByKnowledgeId($id);
    }

    public function getCollectByUserAndKnowledgeId($userId, $knowledgeId)
    {
        return $this->getUserCollectDao()->getCollectByUserAndKnowledgeId($userId, $knowledgeId);
    }

    protected function getUserDao()
    {
        return $this->container['user_dao'];
    }

    protected function getUserLikeDao()
    {
        return $this->container['userLike_dao'];
    }

    protected function getUserCollectDao()
    {
        return $this->container['userCollect_dao'];
    }
}