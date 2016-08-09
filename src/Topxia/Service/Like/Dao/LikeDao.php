<?php

namespace Topxia\Service\Like\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FavoriteDao extends GeneralDaoInterface
{
    public function deleteByIdAndUserId($id, $userId);
}