<?php

namespace Biz\Tag\Dao\Impl;

use Biz\Tag\Dao\TagDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class TagDaoImpl extends GeneralDaoImpl implements TagDao
{
    protected $table = 'tag';

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'name = :name',
            ),
        );        
    }
}