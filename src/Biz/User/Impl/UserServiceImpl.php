<?php
namespace Biz\User\Impl;

use Biz\User\UserService;
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
        $user['id'] = 1;//当前用户,传过来的$id是要查看的用户
        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $user = $this->getUserDao()->get($id);
        if (empty($user)) {
            throw new \Exception('被关注的用户不存在');
        }
        $user = $this->getFollowUserByUserIdAndObjectUserId($user['id'], $id);
        if ($user) {
            throw new \Exception('已经被关注');
        }
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

    public function getUserByUsername($username)
    {
        return $this->getUserDao()->getByUsername($username);
    }

    public function searchMyFollowsByUserIdAndType($userId, $type)
    {
        $conditions = array(
            'userId' => $userId, 
            'type' => $type
        );
        $orderBy = array('id', 'DESC');
        
        $myFollows = $this->getFollowDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);

        return $myFollows;
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