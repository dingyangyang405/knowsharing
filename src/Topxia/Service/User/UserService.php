<?php

namespace Topxia\Service\User;

interface UserService
{
    public function getUser($id);

    public function findUsersByIds($ids);

    public function findUserLikeByKnowledgeId($id);

    public function findUserCollectByKnowledgeId($id);

    public function addUserCollect($fields);

    public function delUserCollect($fields);

    public function addUserLike($fields);

    public function getCollectByUserAndKnowledgeId($userId, $knowledgeId);

}