<?php

namespace Topxia\Service\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function followUser($id);

    public function unfollowUser($id);

    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);
}