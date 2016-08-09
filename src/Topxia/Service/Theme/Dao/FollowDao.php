<?php

namespace Topxia\Service\Theme\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface FollowDao extends GeneralDaoInterface
{
    public function getFollowThemeByUserIdAndThemeId($userId, $themeId, $objectType);

    public function findFollowsByUserId($userId, $objectType);
}