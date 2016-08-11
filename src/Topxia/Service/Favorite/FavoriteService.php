<?php

namespace Topxia\Service\Favorite;

interface FavoriteService
{
    public function getFavoriteCount($conditions);

    public function createFavorite($fields);

    public function deleteFavoriteByIdAndUserId($id, $userId);

    public function findFavoriteByUserId($userId);

}