<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function getKnowledgeCount($conditions);

    public function add($field);

    public function findKnowledgeByUserId($id);

    public function get($id);

    public function addComment($conditions);

    public function searchComments($conditions, $orderBy, $start, $limit);
}