<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function getKnowledgesCount($conditions);

    public function createKnowledge($field);

    public function findKnowledgesByUserId($id);

    public function findKnowledgesByKnowledgeIds($knowledgeIds);

    public function getKnowledge($id);

    public function createComment($conditions);

    public function getCommentsCount($conditions);

    public function searchComments($conditions, $orderBy, $start, $limit);

    public function searchKnowledges($conditions, $orderBy, $start, $limit);

    public function updateKnowledge($id, $fields);

    public function deleteKnowledge($id);

}