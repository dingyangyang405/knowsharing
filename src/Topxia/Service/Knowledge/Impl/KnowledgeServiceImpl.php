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
        return $this->getKnowledgeDao()->find();
    }

    public function addKnowledge($field)
    {
        return $this->getKnowledgeDao()->create($field);
    }
    
    public function getKnowledgeDetial($id)
    {
        return $this->getKnowledgeDao()->get($id);
    }

    public function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}