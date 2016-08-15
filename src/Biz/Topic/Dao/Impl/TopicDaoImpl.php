<?php

namespace Biz\Topic\Dao\Impl;

use Biz\Topic\Dao\TopicDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class TopicDaoImpl extends GeneralDaoImpl implements TopicDao
{
    protected $table = 'topic';

    public function find()
    {
        $sql = "SELECT * FROM {$this->table()} ORDER BY createdTime DESC";
        
        return $this->db()->fetchAll($sql);
    }
    
    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'name = :name'
            ),
        );
    }

}
