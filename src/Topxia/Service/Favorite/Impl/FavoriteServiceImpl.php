<?php

namespace Topxia\Service\Favorite\Impl;

use Topxia\Service\Favorite\FavoriteService;

class FavoriteServiceImpl implements FavoriteService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFavoriteCount($conditions)
    {
        return $this->getDao()->count($conditions);
    }

    public function getDao()
    {
        return $this->container['favorite_dao'];
    }
}