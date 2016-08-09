<?php

namespace Topxia\Service\Favorite\Dao\Impl;

use Topxia\Service\Favorite\Dao\FavoriteDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FavoriteDaoImpl extends GeneralDaoImpl implements FavoriteDao
{
    protected $table = 'user_favorite';

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
            ),
        );
    }
}