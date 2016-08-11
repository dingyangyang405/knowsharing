<?php

namespace Topxia\Service\Like;

interface LikeService
{
    public function createLike($fields);

    public function deleteLikeByIdAndUserId($id, $userId);

    public function findLikeByUserId($userId);
}