<?php

namespace Topxia\Service\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserLikeDao extends GeneralDaoInterface
{
    public function findUserLikeByKnowledgeId($id);
}