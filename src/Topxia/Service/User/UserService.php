<?php

namespace Topxia\Service\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);
}