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

        return $this->getFollowTopicDao()->findFollowsByUserId($user['id'], 'topic');
    }
    
    protected function getTopicDao()
    {
        return $this->container['topic_dao'];
    }

    protected function getFollowTopicDao()
    {
        return $this->container['follow_topic_dao'];
    }
}