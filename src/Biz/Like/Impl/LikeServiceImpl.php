<?php

namespace Biz\Like\Impl;

use Biz\Like\LikeService;
use AppBundle\Common\ArrayToolKit;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class LikeServiceImpl extends KernelAwareBaseService implements LikeService
{
    public function createLike($fields)
    {
        return $this->getLikeDao()->create($fields);
    }

    public function deleteLikeByIdAndUserId($id, $userId)
    {
        return $this->getLikeDao()->deleteByIdAndUserId($id, $userId);
    }

    public function findLikeByUserId($userId)
    {
        return $this->getLikeDao()->findByUserId($userId);
    }

    public function haslikedKnowledge($knowledge,$userId)
    {
        $userId = '1';
        $likes = $this->findLikeByUserId($userId);
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
        return $this->getKnowledgeDao()->update($id, $knowledge);
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
        return $this->getKnowledgeDao()->update($id, $knowledge);
    }

    protected function getLikeDao()
    {
        return $this->biz['like_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->biz['knowledge_dao'];
    }
}