<?php

namespace Topxia\Service\User\Dao\Impl;

use Codeages\Biz\Framework\Dao\GeneralDaoImpl;
use Topxia\Service\User\Dao\UserCollectDao;

class UserCollectDaoImpl extends GeneralDaoImpl implements UserCollectDao
{
    protected $table = 'user_collection';

    public function findUserCollectByKnowledgeId($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE knowledgeId = ? ORDER BY createdTime";
        return $this->db()->fetchAll($sql,array($id));
    }

    public function getCollectByUserAndKnowledgeId($userId, $knowledgeId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userId = ? And knowledgeId = ?";
        return $this->db()->fetchAssoc($sql,array($userId, $knowledgeId));
    }

    public function delUserCollect($fields)
    {
        var_dump($fields);
        exit();
        $sql = "DELETE FROM {$this->table} WHERE userId = :userId AND knowledgeId = :knowledgeId";
        $stmt = $this->db()->prepare($sql);
        $stmlt->excute($fields);
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
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
