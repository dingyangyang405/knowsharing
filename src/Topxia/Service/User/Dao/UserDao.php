<?php

namespace Topxia\Service\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserDao extends GeneralDaoInterface
{
    public function get($id);

    public function findByIds($ids);

    public function addfollow($fields);
}