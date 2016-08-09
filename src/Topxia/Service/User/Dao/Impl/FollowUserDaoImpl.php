<?php

namespace Topxia\Service\User\Dao\Impl;

use Topxia\Service\User\Dao\FollowUserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FollowUserDaoImpl extends GeneralDaoImpl implements FollowUserDao
{
    protected $table = "follow";

    public function getFollowByUserIdAndObjectId($userId, $objectId)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ? AND objectId = ? AND type = ?";

        return $this->db()->fetchAssoc($sql, array($userId, $objectId,'user')) ?: null;
    }

    public function declares()
    {
        return array(
            'timestamps' => array(),
            'serializes' => array(),
            'conditions' => array(),
        );
    }

}