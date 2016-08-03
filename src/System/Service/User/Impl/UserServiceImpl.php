<?php
namespace System\Service\User\Impl;

use System\Service\User\Dao\Impl\UserDaoImpl;

use System\Service\User\UserService;

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