<?php

namespace Topxia\Service\Like\Impl;

use Topxia\Service\Like\LikeService;
use Topxia\Common\ArrayToolKit;

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

    public function findByUserId($userId)
    {
        return $this->getLikeDao()->findByUserId($userId);
    }

    public function haslikedKnowledge($knowledge)
    {
        $userId = '1';
        $likes = $this->findByUserId($userId);
        $likeKnowledgeIds = ArrayToolKit::column($likes, 'knowledgeId');

        $hasliked = array();
        foreach ($knowledge as $singleKnowledge) {
            if (empty($likeKnowledgeIds)) {
                $singleKnowledge['isLiked'] = '';
            } else {
                if(in_array($singleKnowledge['id'], $likeKnowledgeIds)) {
                    $singleKnowledge['isLiked'] = true;
                } else {
                    $singleKnowledge['isLiked'] = '';
                }
            }
            $hasliked[] = $singleKnowledge;
        }
        return $hasliked;
    }        

    public function getLikeDao()
    {
        return $this->container['like_dao'];
    }
}