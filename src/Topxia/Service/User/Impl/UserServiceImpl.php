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

    public function get($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function getFollowObjectStatus($userId,$objectId)
    {
        $objectUser = $this->getFollowDao()->getFollowByUserIdAndObjectId($userId,$objectId);
        if (isset($objectUser)) {
            return true;
        } else {
            return false;
        }
    }

    public function findUsersByIds($ids)
    {
        return $this->getUserDao()->findByIds($ids);
    }

    public function followUser($id)
    {   
        // $user = $this->getCurrentUser();
        $user['id'] = 1;
        $this->getFollowDao()->create(array(
            'userId'=> $user['id'],
            'objectType'=>'user',
            'objectId'=>$id
            ));

        return true;
    }

    public function unfollowUser($id)
    {
        $user['id'] = 1;
        $follow = $this->getFollowDao()->getFollowByUserIdAndObjectId($user['id'], $id);
        $this->getFollowDao()->delete($follow['id']);

        return true;
    }

    protected function getUserDao()
    {
        return $this->container['user_dao'];
    }

    protected function getFollowDao()
    {
        return $this->container['follow_user_dao'];
    }
}