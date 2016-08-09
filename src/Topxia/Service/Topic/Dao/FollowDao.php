<?php

namespace Topxia\Service\Topic\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowDao extends GeneralDaoInterface
{
    public function getFollowTopicByUserIdAndTopicId($userId, $topicId, $objectType);

    public function findFollowsByUserId($userId, $objectType);

    public function addFollow($follow);

    public function deleteFollow($id);
}