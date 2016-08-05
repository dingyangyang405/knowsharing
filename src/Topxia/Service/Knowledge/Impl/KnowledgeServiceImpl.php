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

    public function findKnowledgeCount($conditions)
    {
        return $this->getDao()->count($conditions);
    }

    public function findKnowledges()
    {
        return $this->getDao()->find();
    }

    public function getDao()
    {
        return $this->container['knowledge_dao'];
    }
}