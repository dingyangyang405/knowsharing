<?php

namespace Topxia\Service\Favorite;

interface FavoriteService
{
    public function getFavoriteCount($conditions);

    public function create($fields);

    public function deleteByIdAndUserId($id, $userId);

    public function findByKnowledgeIds($knowledgeIds);

}