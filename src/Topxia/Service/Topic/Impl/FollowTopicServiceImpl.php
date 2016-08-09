<?php

namespace Topxia\Service\Topic\Impl;

use Topxia\Service\Topic\Dao\Impl\TopicDaoImpl;
use Topxia\Service\Topic\FollowTopicService;

class FollowTopicServiceImpl implements FollowTopicService
{
    protected  $container;

    public  function __construct($container)
    {
        $this->container = $container;
    }

    public function followTopic($topicId)
    {
        $user['id'] = 1;
        var_dump($topicId);exit();
        $this->getFollowTopicDao()->create(array(
            'objectId' => $topicId,
            'userId' => $user['id'],
            'type' => 'topic',
        ));

        return true;
    }

    public function unFollowTopic($topicId)
    {
        $user['id'] = 1;

        $follow = $this->getFollowTopicDao()->getFollowTopicByUserIdAndTopicId($user['id'], $topicId, 'topic');
        $this->getFollowTopicDao()->delete($follow['id']);

        return true;
    }

    protected function getFollowTopicDao()
    {
        return $this->container['follow_topic_dao'];
    }
}