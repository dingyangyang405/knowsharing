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
        return $this->getTopicDao()->create($field);
    }

    public function findAllTopics()
    {
        $topics = $this->getTopicDao()->find();

        return $topics;
    }
    
    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }
}