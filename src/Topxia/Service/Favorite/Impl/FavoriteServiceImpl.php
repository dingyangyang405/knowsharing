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
        return $this->getFavoriteDao()->count($conditions);
    }

    public function create($fields)
    {
        return $this->getFavoriteDao()->create($fields);
    }

    public function deleteByIdAndUserId($id, $userId)
    {
        return $this->getFavoriteDao()->deleteByIdAndUserId($id, $userId);
    }

    public function findByKnowledgeIds($knowledgeIds)
    {
        return $this->getFavoriteDao()->findByKnowledgeIds($knowledgeIds);
    }

    public function hasFavoritedKnowledge($Favorites)
    {
        $userId = '1';
        $hasFavorited = array();
        foreach ($Favorites as $Favorite) {
            if ($Favorite['userId'] == $userId) {
                $Favorite['Favorite'] = true;
            } else {
                $Favorite['Favorite'] = false;
            }
            $hasFavorited[] = $Favorite;
        }
        return $hasFavorited;
    }

    public function getFavoriteDao()
    {
        return $this->container['favorite_dao'];
    }
}