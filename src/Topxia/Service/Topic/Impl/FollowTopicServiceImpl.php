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

        $this->getFollowTopicDao()->create(array(
            'objectId' => $topicId,
            'userId' => $user['id'],
            'type' => 'topic',
        ));

        $ids = array($topicId);
        $diffs = array('followNum' => 1);
        $this->waveFollowNum($ids, $diffs);

        return true;
    }

    public function unFollowTopic($topicId)
    {
        $user['id'] = 1;

        $follow = $this->getFollowTopicByUserIdAndTopicId($user['id'], $topicId);
        $this->getFollowTopicDao()->delete($follow[0]['id']);

        $ids = array($topicId);
        $diffs = array('followNum' => -1);
        $this->waveFollowNum($ids, $diffs);


        return true;
    }

    public function getFollowTopicByUserIdAndTopicId($userId, $topicId)
    {
        $conditions = array(
            'userId' => $userId,
            'objectId' => $topicId,
            'type' => 'topic',
        );

        $orderBy = array('objectId', 'ASC');

        return $this->getFollowTopicDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
    }

    public function findFollowedTopics()
    {
        $user['id'] = 1;

        $conditions = array(
            'userId' => $user['id'],
            'type' => 'topic',
        );
        $orderBy = array('objectId', 'ASC');
        
        return $this->getFollowTopicDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
    }

    public function waveFollowNum($ids, $diffs)
    {
        return $this->getTopicDao()->wave($ids, $diffs);
    }

    public function getFollowTopicDao()
    {
        return $this->container['follow_topic_dao'];
    }

    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }
}