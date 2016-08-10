<?php

namespace Topxia\Service\Like;

interface LikeService
{
    public function create($fields);

    public function deleteByIdAndUserId($id, $userId);

    public function findByUserId($userId);
}