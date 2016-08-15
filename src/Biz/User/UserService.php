<?php

namespace Biz\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function followUser($id);

    public function unfollowUser($id);

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);

    public function getUserByUsername($username);

    public function register($user);

    public function searchMyFollowsByUserIdAndType($userId, $type);
}