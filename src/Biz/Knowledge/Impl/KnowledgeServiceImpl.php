<?php

namespace Biz\Knowledge\Impl;

use Biz\Knowledge\KnowledgeService;
use AppBundle\Common\ArrayToolKit;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;
use AppBundle\Common\UpLoad;

class KnowledgeServiceImpl extends KernelAwareBaseService implements KnowledgeService
{
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

    public function searchFollowKnowledges($conditions, $start, $limit)
    {
        return $this->getKnowledgeDao()->searchFollowKnowledges($conditions, $start, $limit);
    }

    public function getFollowKnowledgesCount($conditions)
    {
        return $this->getKnowledgeDao()->getFollowKnowledgesCount($conditions);
    }

    public function findTopKnowledges($type)
    {
        $topConditions = array();
        $topOrderBy = array($type.'Num', 'DESC');
        $topNum = 5;
        $topKnowledges = $this->getKnowledgeDao()->search(
            $topConditions,
            $topOrderBy,
            0,
            $topNum
        );

        return $topKnowledges;
    }

    public function moveToPath($file,$user,$knowledge)
    {
        if (empty($file)) {
            throw new \Exception("上传文档不能为空!");
        } elseif (abs(filesize($file)) > 20971520) {
            throw new \Exception("文件不能大于20M!");
        } elseif (empty($knowledge['title'])) {
            throw new \Exception("标题不能为空!");
        } elseif (strlen($knowledge['title']) > 60) {
            throw new \Exception("标题不能超过20个汉字!");
        } elseif (strlen($knowledge['topic']) > 60) {
            throw new \Exception("主题名不能超过20个汉字!");
        }
        
        $upLoad = new UpLoad($file);
        $path = $upLoad->moveToPath($user,$knowledge['title']);

        return $path;
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
        return $this->getKnowledgeDao()->findKnowledgesByUserId($id);
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
        return $this->getKnowledgeDao()->search($conditions, $orderBy, $start, $limit);
    }

    public function setToreadMark($knowledges, $userId)
    {
        $toreadKnowledgeIds =  $this->getToreadDao()->findToreadIds($userId);
        $toreadKnowledgeIds = ArrayToolkit::index($toreadKnowledgeIds, 'knowledgeId');
        foreach ($knowledges as $key => $value) {
            if (isset($toreadKnowledgeIds[$value['id']])) {
                $knowledges[$key]['toread'] = true;
            }
        }

        return $knowledges;
    }

    public function setLearnedMark($knowledges, $userId)
    {
        $learnedIds = $this->getLearnDao()->findLearnedIds($userId);
        $learnedIds = ArrayToolkit::index($learnedIds, 'knowledgeId');
        foreach ($knowledges as $key => $value) {
            if (isset($learnedIds[$value['id']])) {
                $knowledges[$key]['learned'] = true;
            }
        }

        return $knowledges;
    }

    public function searchKnowledgesByIds($ids, $start, $limit)
    {
        return $this->getKnowledgeDao()->searchKnowledgesByIds($ids, $start, $limit);
    }

    public function searchKnowledgesByIdsWithNoOrder($ids, $start, $limit)
    {
        return $this->getKnowledgeDao()->searchKnowledgesByIdsWithNoOrder($ids, $start, $limit);
    }

    protected function getKnowledgeDao()
    {
        return $this->biz['knowledge_dao'];
    }

    protected function getCommentDao()
    {
        return $this->biz['comment_dao'];
    }

    protected function getToreadDao()
    {
        return $this->biz['toread_dao'];
    }

    protected function getLearnDao()
    {
        return $this->biz['learn_dao'];
    }
}