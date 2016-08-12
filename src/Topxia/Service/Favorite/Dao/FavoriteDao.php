<?php

namespace Topxia\Service\Favorite\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FavoriteDao extends GeneralDaoInterface
{
    public function deleteByIdAndUserId($id, $userId);

    public function findFavoritesByUserId($userId);
}