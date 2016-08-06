<?php

namespace Topxia\Service\Knowledge\Dao\Impl;

use Topxia\Service\Knowledge\Dao\KnowledgeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class KnowledgeDaoImpl extends GeneralDaoImpl implements KnowledgeDao
{
    protected $table = 'knowledge';

    public function find()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY createdTime";
        return $this->db()->fetchAll($sql);
    }

    public function getKnowledgesByUserId($id)
    {   
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ?";

        return $this->db()->fetchAll($sql, array($id)) ?: null;
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime', 'updatedTime'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
            ),
        );
    }
}