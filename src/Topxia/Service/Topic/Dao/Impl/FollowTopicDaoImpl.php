<?php

namespace Topxia\Service\Topic\Dao\Impl;

use Topxia\Service\Topic\Dao\FollowTopicDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FollowTopicDaoImpl extends GeneralDaoImpl implements FollowTopicDao
{
    protected $table = 'follow';

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId, $objectType)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ? AND objectId = ? AND type = ?";

        return $this->db()->fetchAssoc($sql, array($userId, $topicId, $objectType)) ?: null;
    }

    public function findFollowsByUserId($userId, $objectType)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ? AND type = ?";

        return $this->db()->fetchAll($sql, array($userId, $objectType));
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
