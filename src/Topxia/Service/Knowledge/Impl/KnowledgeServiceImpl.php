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

    public function getKnowledgeCount($conditions)
    {
        return $this->getKnowledgeDao()->count($conditions);
    }

    public function findKnowledges()
    {
        return $this->getKnowledgeDao()->find();
    }

    public function findKnowledgeByUserId($id)
    {
        return $this->getKnowledgeDao()->findKnowledgeByUserId($id);
    }
    
    public function add($field)
    {
        return $this->getKnowledgeDao()->create($field);
    }
    
    public function get($id)
    {
        return $this->getKnowledgeDao()->get($id);
    }

    public function addComment($conditions)
    {
        return $this->getCommentDao()->create($conditions);
    }

    public function searchComments($conditions, $orderBy, $start, $limit)
    {
        return $this->getCommentDao()->search($conditions, $orderBy, $start, $limit);
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }

    protected function getCommentDao()
    {
        return $this->container['comment_dao'];
    }
}