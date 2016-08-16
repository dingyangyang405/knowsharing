<?php

namespace Biz\Learn\Impl;

use Biz\Learn\LearnService;

class LearnServiceImpl implements LearnService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getLearnedByIdAndUserId($id, $userId)
    {
        return $this->getLearnDao()->getByIdAndUserId($id, $userId);
    }

    public function finishKnowledgeLearn($id, $userId)
    {
        $fields = array(
            'userId' => $userId,
            'knowledgeId' => $id
        );

        $isToDoList = $this->getToDoListDao()->getToDoListByFields($fields);

        if (!empty($isToDoList)) {
            $this->getToDoListDao()->delete($isToDoList['id']);
        }

        $this->getLearnDao()->create($fields);
        $knowledge = $this->getKnowledgeDao()->get($id);
        $knowledge['viewNum'] += 1; 

        return $this->getKnowledgeDao()->update($id, $knowledge);
    }

    protected function getLearnDao()
    {
        return $this->container['learn_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }

    protected function getToDoListDao()
    {
        return $this->container['todolist_dao'];
    }
}