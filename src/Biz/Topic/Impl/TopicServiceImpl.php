<?php
namespace Biz\Topic\Impl;

use Biz\Topic\Dao\Impl\TopicDaoImpl;
use Biz\Topic\TopicService;

class TopicServiceImpl implements TopicService
{
    protected  $container;

    public  function __construct($container)
    {
        $this->container = $container;
    }

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

    public function getTopicById($id ,$user)
    {
        if (is_numeric($id)) {
            return $this->getTopicDao()->get($id);
        } else {
            $field = array('name' => $id, 'userId' => $user['id']);
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

    public function findKnowledgesByTopicId($id)
    {
        return $this->getKnowledgeDao()->findByTopicId($id);
    }

    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }

    protected function getKnowledgeDao()
    {
        return $this->container['knowledge_dao'];
    }
}