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
        $this->getFollowTopicService()->getFollowTopicDao()->create($topic);
        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 1);
        $this->assertEquals($result[0]['userId'], $topic['userId']);
        $this->assertEquals($result[0]['objectId'], $topic['objectId']);
        $this->assertEquals($result[0]['type'], $topic['type']);
    }

    public function testFollowTopic()
    {
        $this->getFollowTopicService()->followTopic(2);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 2);

        $this->assertEquals(1, $result[0]['userId']);
        $this->assertEquals(2, $result[0]['objectId']);
    }

    public function testUnFollowTopic()
    {
        $this->getFollowTopicService()->followTopic(2);
        $this->getFollowTopicService()->unFollowTopic(2);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 2);

        $this->assertEquals(array(), $result);
    }

    protected function getFollowTopicService()
    {
        return self::$kernel['follow_topic_service'];
    }
}