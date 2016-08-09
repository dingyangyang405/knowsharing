<?php

namespace Topxia\Service\Knowledge\Dao\Impl;

use Topxia\Service\Knowledge\Dao\CommentDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class CommentDaoImpl extends GeneralDaoImpl implements CommentDao
{
    protected $table = 'comment';

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
                'knowledgeId = :knowledgeId',
                'value = :value'
            ),
        );
    }
}