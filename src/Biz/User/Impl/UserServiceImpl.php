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

    public function findTopUsers($type)
    {
        $topConditions = array();
        if ($type == 'score') {
            $topOrderBy = array($type, 'DESC');
        } else {
            $topOrderBy = array($type.'Num', 'DESC');
        }
        $topNum = 5;
        $topUsers = $this->getUserDao()->search(
            $topConditions,
            $topOrderBy,
            0,
            $topNum
        );

        return $topUsers;
    }

    public function findUsersByIds($ids)
    {
        return $this->getUserDao()->findUsersByIds($ids);
    }

    public function getUserByUsername($username)
    {
        return $this->getUserDao()->getByUsername($username);
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
}