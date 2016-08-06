<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function addKnowledge($field);

    public function getKnowledgeDetial($id);
}