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

    public function haslikedKnowledge($knowledge,$userId)
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

    public function dislikeKnowledge($id, $userId)
    {
        $this->getLikeDao()->deleteByIdAndUserId($id, $userId);
        $knowledge = $this->getKnowledgeDao()->get($id);
        $knowledge['likeNum'] = $knowledge['likeNum'] - 1; 
        $this->getKnowledgeDao()->update($id, $knowledge);
    }

    public function likeKnowledge($id, $userId)
    {
        $fields = array(
            'userId' => $userId,
            'knowledgeId' => $id
        );

        $this->getLikeDao()->create($fields);
        $knowledge = $this->getKnowledgeDao()->get($id);
        $knowledge['likeNum'] += 1; 
        $this->getKnowledgeDao()->update($id, $knowledge);
    }

    protected function getLikeDao()
    {
        return $this->container['like_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}