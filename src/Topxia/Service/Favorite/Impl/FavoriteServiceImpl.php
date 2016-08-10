<?php

namespace Topxia\Service\Favorite\Impl;

use Topxia\Service\Favorite\FavoriteService;
use Topxia\Common\ArrayToolKit;

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

    public function findByUserId($userId)
    {
        return $this->getFavoriteDao()->findByUserId($userId);
    }

    public function hasFavoritedKnowledge($knowledge,$userId)
    {
        $userId = '1';
        $favorites = $this->findByUserId($userId);
        $favoriteKnowledgeIds = ArrayToolKit::column($favorites, 'knowledgeId');

        $hasFavorited = array();
        foreach ($knowledge as $singleKnowledge) {
            if (empty($favoriteKnowledgeIds)) {
                $singleKnowledge['isFavorited'] = '';
            } else {
                if(in_array($singleKnowledge['id'], $favoriteKnowledgeIds)) {
                    $singleKnowledge['isFavorited'] = true;
                } else {
                    $singleKnowledge['isFavorited'] = '';
                }
            }
            $hasFavorited[] = $singleKnowledge;
        }
        return $hasFavorited;
    }

    public function getFavoriteDao()
    {
        return $this->container['favorite_dao'];
    }
}
