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

    public function followUser($userId)
    {   
        // $user = $this->getCurrentUser();
        $this->getUserDao()->addfollow(array(
            'userId'=> 1,
            'objectType'=>'user',
            'objectId'=>$userId
            ));
    }

    protected function getUserDao()
    {
        return $this->container['user_dao'];
    }
}