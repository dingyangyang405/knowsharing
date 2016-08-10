<?php

namespace Topxia\Service\Knowledge;

interface KnowledgeShareService
{
    public function searchShareCount($condition);

    public function searchShareKnowledge($conditions, $orderBy, $start, $limit);
}