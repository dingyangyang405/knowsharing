<?php

namespace Topxia\Service\Favorite;

interface FavoriteService
{
    public function getFavoritesCount($conditions);

    public function createFavorite($fields);

    public function deleteFavoritesByIdAndUserId($id, $userId);

    public function findFavoritesByUserId($userId);

}