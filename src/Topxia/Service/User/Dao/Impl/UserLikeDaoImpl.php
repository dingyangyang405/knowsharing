<?php

namespace Topxia\Service\User\Dao\Impl;

use Codeages\Biz\Framework\Dao\GeneralDaoImpl;
use Topxia\Service\User\Dao\UserLikeDao;

class UserLikeDaoImpl extends GeneralDaoImpl implements UserLikeDao
{
    protected $table = 'user_like';

    public function findUserLike()
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