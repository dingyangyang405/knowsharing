<?php
namespace Biz\Topic\Impl;

use Biz\Topic\Dao\Impl\TopicDaoImpl;
use Biz\Topic\TopicService;
use Codeages\Biz\Framework\Service\KernelAwareBaseService;

class TopicServiceImpl extends KernelAwareBaseService implements TopicService
{
    public function createTopic($field)
    {
        if (empty($field)) {
            throw new \Exception('添加内容不能为空');
        }
        $topic = $this->getTopicDao()->get($field['name']);
        if (!empty($topic)) {
            return $topic;
        }
        return $this->getTopicDao()->create($field);
    }

    public function getTopicById($id)
    {
        $field['id'] = $id;
        if (gettype($id) == 'string') {
            return $this->getTopicDao()->get($id);
        } else {
            return $this->getTopicDao()->create($field);
        }
    }

    public function getTopicByName($name)
    {
        if (empty($name)) {
            return $topic['id'] = null;
        }
        $result = $this->getTopicDao()->getTopicByName($name);
        if ($result) {
            return $result;
        } else {
            $field['name'] = $name;
            return $this->getTopicDao()->create($field);
        }
    }

    public function findTopTopics($type)
    {
        $topConditions = array();
        $topOrderBy = array($type.'Num', 'DESC');
        $topNum = 5;
        $topTopics = $this->getTopicDao()->search(
            $topConditions,
            $topOrderBy,
            0,
            $topNum
        );

        return $topTopics;
    }

    public function deleteTopicById($id)
    {
        $topic = $this->getTopicDao()->get($id);
        if (empty($topic)) {
            throw new \Exception('主题不存在,删除失败!');
        }
        return $this->getTopicDao()->delete($id);
    }

    public function findAllTopics()
    {
        $topics = $this->getTopicDao()->find();

        return $topics;
    }

    public function searchTopics($conditions, $orderBy, $start, $limit)
    {
        $topics = $this->getTopicDao()->search($conditions, $orderBy, $start, $limit);

        return $topics;
    }

    public function findTopicsByIds($ids)
    {
        return $this->getTopicDao()->findTopicsByIds($ids);
    }

    public function getTopicsCount($conditions)
    {
        return $this->getTopicDao()->count($conditions);
    }

    protected function getTopicDao()
    {
        return $this->biz['topic_dao'];
    }
}