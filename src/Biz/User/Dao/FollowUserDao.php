<?php

namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowUserDao extends GeneralDaoInterface
{
    public function getFollowUserByUserIdAndObjectUserId($userId,$objectId);

}