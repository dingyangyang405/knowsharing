<?php

namespace Topxia\Service\Theme\Dao\Impl;

use Topxia\Service\Theme\Dao\ThemeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ThemeDaoImpl extends GeneralDaoImpl implements ThemeDao
{
    protected $table = 'theme';

    public function findAllThemes()
    {
        $sql = "SELECT * FROM {$this->table()} ORDER BY createdTime DESC";
        return $this->db()->fetchAll($sql);
    }

    public function declares()
    {
        return array(
            'timestamps' => array(),
            'serializes' => array(),
            'conditions' => array(),
        );
    }

}
