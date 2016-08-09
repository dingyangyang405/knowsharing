<?php

namespace Topxia\Service\Like\Impl;

use Topxia\Service\Like\LikeService;

class FavoriteServiceImpl implements LikeService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function create($fields)
    {
        return $this->getDao()->create($fields);
    }

    public function deleteByIdAndUserId($id, $userId)
    {
        return $this->getDao()->deleteByIdAndUserId($id, $userId);
    }

    public function getDao()
    {
        return $this->container['like_dao'];
    }
}