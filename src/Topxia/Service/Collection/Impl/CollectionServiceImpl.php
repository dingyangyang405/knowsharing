<?php

namespace Topxia\Service\Collection\Impl;

use Topxia\Service\Collection\KnowledgeService;

class CollectionServiceImpl implements CollectionService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function findCollectionCount($conditions)
    {
        return $this->getDao()->count($conditions);
    }

    public function getDao()
    {
        return $this->container['collection_dao'];
    }
}