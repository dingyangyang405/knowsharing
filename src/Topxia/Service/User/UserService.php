<?php

namespace Topxia\Service\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function followUser($userId);

    public function unfollowUser($userId);
}