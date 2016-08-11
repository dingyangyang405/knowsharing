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

    public function createFavorite($fields)
    {
        return $this->getFavoriteDao()->create($fields);
    }

    public function deleteFavoriteByIdAndUserId($id, $userId)
    {
        return $this->getFavoriteDao()->deleteByIdAndUserId($id, $userId);
    }

    public function findFavoriteByUserId($userId)
    {
        return $this->getFavoriteDao()->findByUserId($userId);
    }

    public function hasFavoritedKnowledge($knowledge,$userId)
    {
        $userId = '1';
        $favorites = $this->findFavoriteByUserId($userId);
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

    public function favoriteKnowledge($id, $userId)
    {
        $fields = array(
            'userId' => $userId,
            'knowledgeId' => $id
        );

        $this->getFavoriteDao()->create($fields);
        $knowledge = $this->getKnowledgeDao()->get($id);
        $knowledge['favoriteNum'] += 1; 
        return $this->getKnowledgeDao()->update($id, $knowledge);
    }

    public function unfavoriteKnowledge($id, $userId)
    {
        $this->getFavoriteDao()->deleteByIdAndUserId($id, $userId);
        $knowledge = $this->getKnowledgeDao()->get($id);
        $knowledge['favoriteNum'] = $knowledge['favoriteNum'] - 1; 
        return $this->getKnowledgeDao()->update($id, $knowledge);
    }

    protected function getFavoriteDao()
    {
        return $this->container['favorite_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}
