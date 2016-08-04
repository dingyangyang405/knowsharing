<?php
namespace Topxia\Service\User\Impl;

use Topxia\Service\User\Dao\Impl\UserDaoImpl;

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
    protected function getUserDao()
    {
        return $this->container['user_dao'];
    }
}