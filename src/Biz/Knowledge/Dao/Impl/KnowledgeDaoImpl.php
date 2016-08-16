<?php

namespace Biz\Knowledge\Dao\Impl;

use Biz\Knowledge\Dao\KnowledgeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class KnowledgeDaoImpl extends GeneralDaoImpl implements KnowledgeDao
{
    protected $table = 'knowledge';

    public function find()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY createdTime DESC";
        return $this->db()->fetchAll($sql);
    }

    public function findKnowledgesByUserId($id)
    {   
        $sql = "SELECT * FROM {$this->table()} WHERE userId = ?";

        return $this->db()->fetchAll($sql, array($id)) ?: null;
    }

    public function findKnowledgesByKnowledgeIds($knowledgeIds)
    {
        if (empty($knowledgeIds)) {
            return array();
        }
        
        $marks = str_repeat('?,', count($knowledgeIds)-1).'?';
        $sql = "SELECT * FROM {$this->table} WHERE id IN ({$marks})";
        return $this->db()->fetchAll($sql,$knowledgeIds);
    }

    public function searchKnowledgesByIds($ids, $start, $limit)
    {
        if (empty($ids)) {
            return array();
        }

        $marks = str_repeat('?,', count($ids)-1).'?';
        $start = (int) $start;
        $limit = (int) $limit;

        $sql = "SELECT * FROM {$this->table} WHERE id IN ({$marks}) ORDER BY createdTime DESC LIMIT {$start}, {$limit}";

        return $this->db()->fetchAll($sql,$ids);
    }
    public function findByTopicId($id)
    {
        return $this->findInField('topicId',array($id));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime', 'updatedTime'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
                'title Like :title',
                'id IN (:ids)'
            ),
        );
    }
}