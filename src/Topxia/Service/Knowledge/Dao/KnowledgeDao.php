<?php

namespace Topxia\Service\Knowledge\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface KnowledgeDao extends GeneralDaoInterface
{
    public function find();

    public function findKnowledgesByUserId($id);

    public function findKnowledgesByKnowledgeIds($knowledgeIds);

}