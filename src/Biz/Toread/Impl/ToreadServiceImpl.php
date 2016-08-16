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
        $user = $this->container->getUser();

        if (empty($user)) {
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

        $browsedKnowledge = $this->getLearnDao()->getByIdAndUserId($id, $user['id']);
        if (!empty($browsedKnowledge)) {
            throw new \Exception('已经学过的知识就不要加入待读列表啦');
        }

        $this->getToreadDao()->create(array(
            'userId' => $user['id'],
            'knowledgeId' => $id,
        ));

        return true;
    }

    public function deleteToreadKnowledge($id)
    {
        $user = $this->container->getUser();

        if (empty($user)) {
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

    protected function getLearnDao()
    {
        return $this->container['learn_dao'];
    }
}