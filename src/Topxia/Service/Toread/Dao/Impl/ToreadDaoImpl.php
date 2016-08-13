<?php

namespace Topxia\Service\Toread\Dao\Impl;

use Topxia\Service\Toread\Dao\ToreadDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ToreadDaoImpl extends GeneralDaoImpl implements ToreadDao
{
    protected $table = 'todolist';

    public function getToreadByUserIdAndKnowledgeId($fields)
    {
        return $this->getByFields($fields);
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'name = :name',
            ),
        );
    }
}