<?php

namespace Biz\Toread\Dao\Impl;

use Biz\Toread\Dao\ToreadDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ToreadDaoImpl extends GeneralDaoImpl implements ToreadDao
{
    protected $table = 'todolist';

    public function getToreadByUserIdAndKnowledgeId($fields)
    {
        return $this->getByFields($fields);
    }

    public function findToreadIds($userId)
    {
        $sql = "SELECT knowledgeId FROM {$this->table} WHERE userId = ?";

        return $this->db()->fetchAll($sql, array($userId));
    }
    
    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'name = :name',
                'userId = :userId',
            ),
        );
    }
}