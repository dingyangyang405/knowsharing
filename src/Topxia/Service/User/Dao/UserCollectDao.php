<?php

namespace Topxia\Service\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserCollectDao extends  GeneralDaoInterface
{
    public function findUserCollectByKnowledgeId($id);

    public function getCollectByUserAndKnowledgeId($userId, $knowledgeId);
}
