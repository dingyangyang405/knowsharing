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
        $followedTopics = $this->findAllFollowedTopics();
        foreach ($topics as $key => $topic) {
            $topics[$key]['hasFollowed'] = false;
            foreach ($followedTopics as $value) {
                if ($topic['id'] === $value['objectId']) {
                    $topics[$key]['hasFollowed'] = true;
                }
            }
        }

        return $topics;
    }

    public function findAllFollowedTopics()
    {
        $user['id'] = 1;

        return $this->getFollowDao()->findFollowsByUserId($user['id'], 'topic');
    }

    public function followTopic($topicId)
    {
        $user['id'] = 1;

        $this->getFollowDao()->addFollow(array(
            'objectId' => $topicId,
            'userId' => $user['id'],
            'objectType' => 'topic',
        ));

        return true;
    }

    public function unfollowTopic($topicId)
    {
        $user['id'] = 1;

        $follow = $this->getFollowDao()->getFollowTopicByUserIdAndTopicId($user['id'], $topicId, 'topic');
        $this->getFollowDao()->deleteFollow($follow['id']);

        return true;
    }
    
    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }

    protected function getFollowDao()
    {
        return $this->container['follow_dao'];
    }
}