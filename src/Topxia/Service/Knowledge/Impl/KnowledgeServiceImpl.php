<?php

namespace Topxia\Service\Knowledge\Impl;

use Topxia\Service\Knowledge\KnowledgeService;
use Topxia\Common\ArrayToolKit;


class KnowledgeServiceImpl implements KnowledgeService
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function updateKnowledge($id, $fields)
    {
        $fields = ArrayToolkit::filter($fields, array(
            'title'   => '',
            'summary' => '',
            'content' => ''
        ));

        if (empty($fields['title'])) {
            throw new \RuntimeException('标题不能为空！');
        }

        if (empty($fields['summary'])) {
            throw new \RuntimeException('摘要不能为空！');
        }

        return $this->getKnowledgeDao()->update($id, $fields);
    }

    public function deleteKnowledge($id)
    {
        return $this->getKnowledgeDao()->delete($id);
    }

    public function getKnowledgesCount($conditions)
    {
        return $this->getKnowledgeDao()->count($conditions);
    }

    public function findKnowledges()
    {
        return $this->getKnowledgeDao()->find();
    }

    public function findKnowledgesByUserId($id)
    {
        $knowledges = $this->getKnowledgeDao()->findKnowledgesByUserId($id);
        $knowledges = $this->setToreadMark($knowledges);

        return $knowledges;
    }

    public function findKnowledgesByKnowledgeIds($knowledgeIds)
    {
        return $this->getKnowledgeDao()->findKnowledgesByKnowledgeIds($knowledgeIds);
    }
    
    public function createKnowledge($field)
    {
        return $this->getKnowledgeDao()->create($field);
    }
    
    public function getKnowledge($id)
    {
        return $this->getKnowledgeDao()->get($id);
    }

    public function createComment($conditions)
    {
        if (empty($conditions['value'])) {
            throw new \RuntimeException("评论内容为空！");
        } elseif (strlen($conditions['value']) > 100) {
            throw new \RuntimeException("评论内容不能超过100字！");
        }

        return $this->getCommentDao()->create($conditions);
    }

    public function getCommentsCount($conditions)
    {
        return $this->getCommentDao()->count($conditions);
    }

    public function searchComments($conditions, $orderBy, $start, $limit)
    {
        return $this->getCommentDao()->search($conditions, $orderBy, $start, $limit);
    }

    public function searchKnowledges($conditions, $orderBy, $start, $limit)
    {
        $knowledges = $this->getKnowledgeDao()->search($conditions, $orderBy, $start, $limit);

        $knowledges = $this->setToreadMark($knowledges);

        return $knowledges;
    }

    protected function setToreadMark($knowledges)
    {
        $user['id'] = 1;
        if (!empty($user['id'])) {
            $toreadKnowledgeIds =  $this->getToreadDao()->findToreadIds($user['id']);
            $toreadKnowledgeIds = ArrayToolkit::index($toreadKnowledgeIds, 'knowledgeId');
            foreach ($knowledges as $key => $value) {
                if (isset($toreadKnowledgeIds[$value['id']])) {
                    $knowledges[$key]['toread'] = true;
                }
            }
        }

        return $knowledges;
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }

    protected function getCommentDao()
    {
        return $this->container['comment_dao'];
    }

    protected function getToreadDao()
    {
        return $this->container['toread_dao'];
    }
}