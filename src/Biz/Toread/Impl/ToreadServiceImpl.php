<?php

namespace Biz\Toread\Impl;

use Biz\Toread\ToreadService;

class ToreadServiceImpl implements ToreadService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function createToreadKnowledge($id)
    {
        $user['id'] = 1;

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $knowledge = $this->getKnowledgeDao()->get($id);
        if (empty($knowledge)) {
            throw new \Exception('知识不存在');
        }

        $toreadKnowledge = $this->getToreadDao()->getToreadByUserIdAndKnowledgeId(array(
                'userId' => $user['id'],
                'knowledgeId' => $id,
            ));
        if (($toreadKnowledge)) {
            throw new \Exception('待读列表中已经有该知识');
        }

        $this->getToreadDao()->create(array(
            'userId' => $user['id'],
            'knowledgeId' => $id,
        ));

    }

    public function deleteToreadKnowledge($id)
    {
        $user['id'] = 1;

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $knowledge = $this->getKnowledgeDao()->get($id);
        if (empty($knowledge)) {
            throw new \Exception('知识不存在');
        }

        $toreadKnowledge = $this->getToreadDao()->getToreadByUserIdAndKnowledgeId(array(
                'userId' => $user['id'],
                'knowledgeId' => $id,
            ));
        if (empty($toreadKnowledge)) {
            throw new \Exception('待读列表中没有该知识');
        }

        $this->getToreadDao()->delete($toreadKnowledge['id']);
    }

    protected function getToreadDao()
    {
        return $this->container['toread_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}