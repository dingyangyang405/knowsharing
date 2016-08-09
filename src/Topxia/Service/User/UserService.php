<?php

namespace Topxia\Service\User;

interface UserService
{
    public function get($id);

    // public function getObject($userId,$type,$objectId);

    public function findUsersByIds($ids);

    public function followUser($id);

    public function unfollowUser($id);

    public function findUserLikeByKnowledgeId($id);

    public function findUserCollectByKnowledgeId($id);

    public function addUserCollect($fields);

    public function delUserCollect($fields);

    public function addUserLike($fields);

    public function getCollectByUserAndKnowledgeId($userId, $knowledgeId);
}