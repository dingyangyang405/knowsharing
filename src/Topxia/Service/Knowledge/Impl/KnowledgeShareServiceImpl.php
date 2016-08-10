<?php

namespace Topxia\Service\Knowledge\Impl;

use Topxia\Service\Knowledge\KnowledgeShareService;

class KnowledgeShareServiceImpl implements KnowledgeShareService
{
    public function searchShareCount($condition)
    {
        $this->getKnowledgeDao()->count($condition);
    }

    public function searchShareKnowledge($conditions, $orderBy, $start, $limit)
    {
        $this->getKnowledgeDao()->search($conditions, $orderBy, $start, $limit);
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}