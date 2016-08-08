<?php

namespace Topxia\Service\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function findUserKnowledgesLike();

    public function findUserKnowledgesCollect();

    public function addUserCollect($fields);

    public function addUserLike($fields);
}