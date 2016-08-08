<?php

namespace Topxia\Service\User\Dao\Impl;

use Codeages\Biz\Framework\Dao\GeneralDaoImpl;
use Topxia\Service\User\Dao\UserCollectDao;

class UserCollectDaoImpl extends GeneralDaoImpl implements UserCollectDao
{
    protected $table = 'user_collection';

    public function findUserCollect()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY createdTime";
        return $this->db()->fetchAll($sql);
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'id = :id',
                'name = :name',
                'status = :status',
                'type = :type',
            ),
        );
    }
}
