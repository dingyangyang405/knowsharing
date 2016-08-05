<?php

namespace Topxia\Service\Knowledge\Impl;

use Topxia\Service\Knowledge\KnowledgeService;

class KnowledgeServiceImpl implements KnowledgeService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function findKnowledges()
    {
        return $this->getDao()->find();
    }

    public function addKnowledge($field)
    {
        return $this->getDao()->create($field);
    }

    public function getDao()
    {
        return $this->container['knowledge_dao'];
    }
}