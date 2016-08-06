<?php

namespace Topxia\Service\Collection\Dao\Impl;

use Topxia\Service\Collection\Dao\CollectionDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class CollectionDaoImpl extends GeneralDaoImpl implements CollectionDao
{
    protected $table = 'user_collection';

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
            ),
        );
    }
}