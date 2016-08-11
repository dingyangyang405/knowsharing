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

    public function findAllTopics()
    {
        $topics = $this->getTopicDao()->findAllTopics();

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