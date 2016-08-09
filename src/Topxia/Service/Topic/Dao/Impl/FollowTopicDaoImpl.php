<?php

namespace Topxia\Service\Topic\Dao\Impl;

use Topxia\Service\Topic\Dao\FollowTopicDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FollowTopicDaoImpl extends GeneralDaoImpl implements FollowTopicDao
{
    protected $table = 'follow';

    public function declares()
    {
        return array(
            'timestamps' => array(),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
                'objectId = :objectId',
                'type = :type'
            ),
        );
    }

}
