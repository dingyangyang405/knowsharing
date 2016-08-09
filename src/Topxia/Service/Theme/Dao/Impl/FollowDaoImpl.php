<?php

namespace Topxia\Service\Theme\Dao\Impl;

use Topxia\Service\Theme\Dao\FollowDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FollowDaoImpl extends GeneralDaoImpl implements FollowDao
{
    protected $table = 'follow';

    public function getFollowThemeByUserIdAndThemeId($userId, $themeId, $objectType)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ? AND objectId = ? AND objectType = ?";

        return $this->db()->fetchAssoc($sql, array($userId, $themeId, $objectType)) ?: null;
    }

    public function findFollowsByUserId($userId, $objectType)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ? AND objectType = ?";

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
