<?php

namespace Topxia\Service\User;

interface UserService
{
    public function get($id);

    public function findByIds($ids);

    public function followUser($id);

    public function unfollowUser($id);

}