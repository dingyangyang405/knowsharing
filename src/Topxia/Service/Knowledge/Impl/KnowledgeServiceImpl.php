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
        return $this->getKnowledgeDao()->count($conditions);
    }

    public function findKnowledges()
    {
        return $this->getKnowledgeDao()->find();
    }

    public function getKnowledgesByUserId($id)
    {
        return $this->getKnowledgeDao()->getKnowledgesByUserId($id);
    }
    
    public function addKnowledge($field)
    {
        return $this->getKnowledgeDao()->create($field);
    }
    
    public function getKnowledgeDetial($id)
    {
        return $this->getKnowledgeDao()->get($id);
    }

    public function addComment($conditions)
    {
        return $this->getCommentDao()->create($conditions);
    }

    public function searchComments($id)
    {
        $conditions = array('knowledgeId' => $id);
        $orderBy = array('createdTime', 'DESC');

        return $this->getCommentDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
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