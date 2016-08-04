<?php

namespace Topxia\Service\User\Dao\Impl;

use Topxia\Service\User\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl implements UserDao
{
    protected $table = 'user';

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
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
