<?php

use Topxia\Service\Topic\Impl\FollowTopicServiceImpl;
use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class FollowTopicServiceTest extends BaseTestCase
{
    public function testGetFollowTopicByUserIdAndTopicId()
    {   
        $topic = array(
            'objectId' => 1,
            'userId' => 1,
            'type' => 'topic',
        );
        $this->getFollowTopicService()->getTopicDao()->create($topic);
        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 1);

        $this->assertEqual($result['userId'], $topic['userId']);
        $this->assertEqual($result['objectId'], $topic['objectId']);
        $this->assertEqual($result['type'], $topic['type']);
    }

    public function testFollowTopic()
    {
        $this->getFollowTopicService()->followTopic(2);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 2);

        $this->assertEqual(1, $result['userId']);
        $this->assertEqual(2, $result['objectId']);
    }

    public function testUnFollowTopic()
    {
        $this->getFollowTopicService()->unFollowTopic(2);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 2);

        $this->assertEqual(null, $result);
    }

    

    protected function getFollowTopicService()
    {
        return self::$kernel['follow_topic_service'];
    }
}