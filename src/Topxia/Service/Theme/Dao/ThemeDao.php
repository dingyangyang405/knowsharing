<?php

namespace Topxia\Service\Theme\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface ThemeDao extends GeneralDaoInterface
{
    public function findAllThemes();
}