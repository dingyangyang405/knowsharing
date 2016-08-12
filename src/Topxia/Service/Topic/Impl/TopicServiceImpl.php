<?php
namespace Topxia\Service\Topic\Impl;

use Topxia\Service\Topic\Dao\Impl\TopicDaoImpl;
use Topxia\Service\Topic\TopicService;

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
        return $this->getTopicDao()->create($field);
    }

    public function getTopicById($id)
    {
        return $this->getTopicDao()->get($id);
    }

    public function deleteTopicById($id)
    {
        if (empty($id)) {
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

    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }
}