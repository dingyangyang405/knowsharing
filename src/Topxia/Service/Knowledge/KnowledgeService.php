<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeService
{
    public function findKnowledges();

    public function findKnowledgeCount($conditions);

    public function getKnowledgeDetial($id);
}