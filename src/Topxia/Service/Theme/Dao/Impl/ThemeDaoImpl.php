<?php

namespace Topxia\Service\Theme\Dao\Impl;

use Topxia\Service\Theme\Dao\ThemeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ThemeDaoImpl extends GeneralDaoImpl implements ThemeDao
{
    protected $table = 'theme';

    public function findAllThemes()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'serializes' => array(),
            'conditions' => array(
                'id = :id',
                'name = :name',
                'status = :status',
                'type = :type',
            ),
        );
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'serializes' => array(),
            'conditions' => array(
                'id = :id',
                'name = :name',
                'status = :status',
                'type = :type',
            ),
        );
    }

}
