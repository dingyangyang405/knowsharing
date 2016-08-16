<?php

namespace Biz\Toread\Impl;

use Biz\Toread\ToreadService;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class ToreadServiceImpl extends KernelAwareBaseService implements ToreadService
{
    public function createToreadKnowledge($id, $userId)
    {
        $knowledge = $this->getKnowledgeDao()->get($id);
        if (empty($knowledge)) {
            throw new \Exception('知识不存在');
        }

        $toreadKnowledge = $this->getToreadDao()->getToreadByUserIdAndKnowledgeId(array(
                'userId' => $userId,
                'knowledgeId' => $id,
            ));
        if (($toreadKnowledge)) {
            throw new \Exception('待读列表中已经有该知识');
        }

        $browsedKnowledge = $this->getLearnDao()->getByIdAndUserId($id, $userId);
        if (!empty($browsedKnowledge)) {
            throw new \Exception('已经学过的知识就不要加入待读列表啦');
        }

        $this->getToreadDao()->create(array(
            'userId' => $userId,
            'knowledgeId' => $id,
        ));

        return true;
    }

    public function deleteToreadKnowledge($id, $userId)
    {
        $knowledge = $this->getKnowledgeDao()->get($id);
        if (empty($knowledge)) {
            throw new \Exception('知识不存在');
        }

        $toreadKnowledge = $this->getToreadDao()->getToreadByUserIdAndKnowledgeId(array(
                'userId' => $userId,
                'knowledgeId' => $id,
            ));
        if (empty($toreadKnowledge)) {
            throw new \Exception('待读列表中没有该知识');
        }

        $this->getToreadDao()->delete($toreadKnowledge['id']);
    }

    public function getToreadlistCount($conditons)
    {
        return $this->getToreadDao()->count($conditons);
    }

    protected function getToreadDao()
    {
        return $this->biz['toread_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->biz['knowledge_dao'];
    }

    protected function getLearnDao()
    {
        return $this->biz['learn_dao'];
    }
}