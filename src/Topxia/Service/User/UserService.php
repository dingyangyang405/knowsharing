<?php

namespace Topxia\Service\User;

interface UserService
{
    public function get($id);

    // public function getObject($userId,$type,$objectId);

    public function findUsersByIds($ids);

    public function followUser($id);

    public function unfollowUser($id);

}