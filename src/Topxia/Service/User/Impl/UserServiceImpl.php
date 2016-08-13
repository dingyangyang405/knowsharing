<?php
namespace Topxia\Service\User\Impl;

use Topxia\Service\User\UserService;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class UserServiceImpl extends KernelAwareBaseService implements UserService
{
    public function getUser($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId)
    {
        $objectUser = $this->getFollowDao()->getFollowUserByUserIdAndObjectUserId($userId,$objectId);
        if (isset($objectUser)) {
            return true;
        } else {
            return false;
        }
    }

    public function findUsersByIds($ids)
    {
        return $this->getUserDao()->findUsersByIds($ids);
    }

    public function followUser($id)
    {   
        // $user = $this->getCurrentUser();
        $user['id'] = 1;
        $followUser = $this->getFollowDao()->create(array(
            'userId'=> $user['id'],
            'type'=>'user',
            'objectId'=>$id
        ));
        if ($user['id'] ==1 && $followUser['objectId'] ==$id) {
            return true;
        } else {
            throw new \RuntimeException("关注该用户失败");
        }    
    }

    public function unfollowUser($id)
    {
        $user['id'] = 1;
        $followUser = $this->getFollowDao()->getFollowUserByUserIdAndObjectUserId($user['id'], $id);
        $status = $this->getFollowDao()->delete($followUser['id']);
        if ($status == 1) {
            return true;
        } else {
            throw new \RuntimeException("取消关注该用户失败");
        }  
    }

    public function getUserByUsername($name)
    {
        return $this->getUserDao()->getByUsername($name);
    }

    public function searchMyFollowedsByUserIdAndType($userId, $type)
    {
        $conditions = array(
            'userId' => $userId, 
            'type' => $type
        );
        $orderBy = array('id', 'DESC');
        $myFolloweds = $this->getFollowDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);

        return $myFolloweds;
    }

    public function register($user)
    {
        $user['salt'] = md5(time().mt_rand(0, 1000));
        $user['password'] = $this->container['password_encoder']->encodePassword($user['password'], $user['salt']);
        if (empty($user['roles'])) {
            $user['roles'] = array('ROLE_USER');
        }

        return $this->getUserDao()->create($user);
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