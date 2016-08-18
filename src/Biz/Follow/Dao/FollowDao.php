<?php

namespace Biz\Follow\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowDao extends GeneralDaoInterface
{
    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);

    public function updateFollowByTopicId($topicId, $addNumber, $type);

    public function updateFollowByUserId($userId, $addNumber, $type);
}