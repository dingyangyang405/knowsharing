<?php

namespace Topxia\Service\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserDao extends GeneralDaoInterface
{
    public function get($id);

    public function findUsersByIds($ids);

    public function getByUsername($username);
}