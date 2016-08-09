<?php

namespace Topxia\Service\Like\Dao\Impl;

use Topxia\Service\Like\Dao\LikeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class LikeDaoImpl extends GeneralDaoImpl implements LikeDao
{
    protected $table = 'user_like';

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