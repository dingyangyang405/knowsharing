<?php

namespace Topxia\Service\Favorite\Dao\Impl;

use Topxia\Service\Favorite\Dao\FavoriteDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class FavoriteDaoImpl extends GeneralDaoImpl implements FavoriteDao
{
    protected $table = 'user_favorite';

    public function deleteByIdAndUserId($id, $userId)
    {
        $sql = "DELETE FROM {$this->table} WHERE userId = :userId AND knowledgeId = :knowledgeId";
        $stmt = $this->db()->prepare($sql);
        $fields = array(
            'userId' => $userId,
            'knowledgeId' => $id
            );
        $stmt->execute($fields);        
    }

    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userId =?";
        return $this->db()->fetchAll($sql,array($userId));        
    }

    public function declares()
    {
        return array(
            'timestamps' => array('createdTime'),
            'serializes' => array(),
            'conditions' => array(
                'userId = :userId',
            ),
        );
    }
}