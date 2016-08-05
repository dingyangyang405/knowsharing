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
        return $this->$db()->fetchAll($sql,array());
    }
}