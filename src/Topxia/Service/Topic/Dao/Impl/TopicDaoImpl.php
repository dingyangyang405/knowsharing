<?php

namespace Topxia\Service\Topic\Dao\Impl;

use Topxia\Service\Topic\Dao\TopicDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class TopicDaoImpl extends GeneralDaoImpl implements TopicDao
{
    protected $table = 'topic';

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table()} ORDER BY createdTime DESC";
        return $this->db()->fetchAll($sql);
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
