<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function findKnowledgeCount($conditions);

    public function addKnowledge($field);

    public function getKnowledgesByUserId($id);

    public function getKnowledgeDetial($id);

}