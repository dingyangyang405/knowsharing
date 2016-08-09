<?php

namespace Topxia\Service\Like\Impl;

use Topxia\Service\Like\LikeService;

class LikeServiceImpl implements LikeService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function create($fields)
    {
        return $this->getLikeDao()->create($fields);
    }

    public function deleteByIdAndUserId($id, $userId)
    {
        return $this->getLikeDao()->deleteByIdAndUserId($id, $userId);
    }

    public function getLikeDao()
    {
        return $this->container['like_dao'];
    }
}