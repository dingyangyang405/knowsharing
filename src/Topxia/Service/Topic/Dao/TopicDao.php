<?php

namespace Topxia\Service\Topic\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface TopicDao extends GeneralDaoInterface
{
    public function find();
}