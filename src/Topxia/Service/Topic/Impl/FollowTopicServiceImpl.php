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

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $topic = $this->getTopicDao()->get($topicId);
        if (empty($topic)) {
            throw new \Exception('主题不存在');
        }

        $followed = $this->getFollowTopicByUserIdAndTopicId($user['id'], $topicId);
        if ($followed) {
            throw new \Exception('已经被关注');
        }

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

        if (empty($user['id'])) {
            throw new \Exception('用户不存在');
        }

        $topic = $this->getTopicDao()->get($topicId);
        if (empty($topic)) {
            throw new \Exception('主题不存在');
        }

        $followed = $this->getFollowTopicByUserIdAndTopicId($user['id'], $topicId);
        if (empty($followed)) {
            throw new \Exception('未被关注');
        }

        $this->getFollowTopicDao()->delete($followed[0]['id']);

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

    public function findFollowedTopicsByUserId($userId)
    {
        $conditions = array(
            'userId' => $userId,
            'type' => 'topic',
        );
        $orderBy = array('objectId', 'ASC');
        
        return $this->getFollowTopicDao()->search($conditions, $orderBy, 0, PHP_INT_MAX);
    }

    public function waveFollowNum($ids, $diffs)
    {
        return $this->getTopicDao()->wave($ids, $diffs);
    }

    public function hasFollowedTopics($topics,$userId)
    {
        $followedTopics = $this->findFollowedTopicsByUserId($userId);
        $followedTopicIds = array();
        foreach ($followedTopics as $value) {
            $followedTopicIds[] = $value['objectId'];
        }
        foreach ($topics as $key => $topic) {
            $topics[$key]['hasFollowed'] = false;
            if (in_array($topic['id'], $followedTopicIds)) {
                $topics[$key]['hasFollowed'] = true;
            }
        }
        return $topics;
    }

    protected function getFollowTopicDao()
    {
        return $this->container['follow_topic_dao'];
    }

    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }
}