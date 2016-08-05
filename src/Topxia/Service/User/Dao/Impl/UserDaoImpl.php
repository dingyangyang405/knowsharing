<?php

namespace Topxia\Service\User\Dao\Impl;

use Topxia\Service\User\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl implements UserDao
{
    protected $table = 'user';

    public function get($id)
    {
        $sql = "SELECT * FROM {$this->table()} WHERE id = ?";

        return $this->db()->fetchAssoc($sql, array($id)) ?: null;
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'serializes' => array(),
            'conditions' => array(
                'id = :id'
            ),
        );
    }

}
