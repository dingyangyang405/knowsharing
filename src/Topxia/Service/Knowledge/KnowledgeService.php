<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function find();

    public function get($id);
    
    public function getKnowledge($id);

    public function searchCommentsCount($conditions);

    public function getCommentsCount($conditions);

    public function searchAllKnowledge($conditions, $orderBy, $start, $limit);
    
    public function searchComments($conditions, $orderBy, $start, $limit);

    public function findKnowledgeByUserId($id);

    public function add($field);

    public function addComment($conditions);

    public function updateknowledge($id, $fields);

    public function deleteknowledge($id);
}