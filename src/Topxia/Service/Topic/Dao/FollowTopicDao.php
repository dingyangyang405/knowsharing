<?php

namespace Topxia\Service\Topic\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowTopicDao extends GeneralDaoInterface
{
    public function getFollowTopicByUserIdAndTopicId($userId, $topicId, $objectType);

    public function findFollowsByUserId($userId, $objectType);
}