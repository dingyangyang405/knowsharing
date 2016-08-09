<?php

namespace Topxia\Service\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowUserDao extends GeneralDaoInterface
{
    public function getFollowByUserIdAndObjectId($id, $userId, $objectType);
}