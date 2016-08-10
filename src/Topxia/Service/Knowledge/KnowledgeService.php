<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function find();

    public function getKnowledgeCount($conditions);

    public function add($field);

    public function findKnowledgeByUserId($id);

    public function get($id);

    public function addComment($conditions);

    public function searchComments($conditions, $orderBy, $start, $limit);

    public function getCommentsCount($conditions);

    public function update($id, $fields);

}