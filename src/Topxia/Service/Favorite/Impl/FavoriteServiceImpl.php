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

    public function hasFavoritedKnowledge($knowledges)
    {
        $userId = '1';
        $favorites = $this->findByUserId($userId);
        $favoriteKnowledgeIds = ArrayToolKit::column($favorites, 'knowledgeId');

        $hasFavorited = array();
        foreach ($knowledges as $knowledge) {
            if (empty($favoriteKnowledgeIds)) {
                $knowledge['isFavorited'] = '';
            } else {
                if(in_array($knowledge['id'], $favoriteKnowledgeIds)) {
                    $knowledge['isFavorited'] = true;
                } else {
                    $knowledge['isFavorited'] = '';
                }
            }
            $hasFavorited[] = $knowledge;
        }
        return $hasFavorited;
    }

    public function getFavoriteDao()
    {
        return $this->container['favorite_dao'];
    }
}
