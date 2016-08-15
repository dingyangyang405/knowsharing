<?php

use Topxia\Service\Topic\Impl\FollowTopicServiceImpl;
use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class FollowTopicServiceTest extends BaseTestCase
{
    public function testGetFollowTopicByUserIdAndTopicId()
    {   
        $follow = array(
            'objectId' => 1,
            'userId' => 1,
            'type' => 'topic',
        );
        $this->getFollowTopicDao()->create($follow);
        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 1);
        $this->assertEquals($result[0]['userId'], $follow['userId']);
        $this->assertEquals($result[0]['objectId'], $follow['objectId']);
        $this->assertEquals($result[0]['type'], $follow['type']);
    }

    public function testFollowTopic()
    {   
        $topic = array(
            'name' => '编程语言',
            'createdTime' => 1231231231,
            'userId' => 1,
            'followNum' => 1,
        );
        $this->getTopicDao()->create($topic);
        $this->getFollowTopicService()->followTopic(1);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 1);

        $this->assertEquals(1, $result[0]['userId']);
        $this->assertEquals(1, $result[0]['objectId']);
    }

    public function testUnFollowTopic()
    {
        $topic = array(
            'name' => '编程语言',
            'createdTime' => 1231231231,
            'userId' => 1,
            'followNum' => 1,
        );
        $this->getTopicDao()->create($topic);
        $this->getTopicDao()->create($topic);
        $this->getFollowTopicService()->followTopic(2);
        $this->getFollowTopicService()->unFollowTopic(2);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 2);

        $this->assertEquals(array(), $result);
    }

    public function testFindFollowedTopics()
    {
        $topic = array(
            0 => array(
                'objectId' => 1,
                'userId' => 1,
                'type' => 'topic',
            ),
            1 => array(
                'objectId' => 2,
                'userId' => 1,
                'type' => 'topic',
            ),
            2 => array(
                'objectId' => 1,
                'userId' => 1,
                'type' => 'user',
            ),
        );
        $this->getFollowTopicDao()->create($topic[0]);
        $this->getFollowTopicDao()->create($topic[1]);
        $result = $this->getFollowTopicService()->findFollowedTopics();

        $this->assertEquals(2, count($result));
        $this->assertEquals('1', $result[0]['id']);
        $this->assertEquals('2', $result[1]['id']);
    }

    public function testWaveFollowNum()
    {
        $topic = array(
            'name' => '编程语言',
            'createdTime' => 1231231231,
            'userId' => 1,
            'followNum' => 1,
        );
        $this->getTopicDao()->create($topic);

        $ids = array(1);
        $diffs = array('followNum' => 1);
        $this->getFollowTopicService()->waveFollowNum($ids, $diffs);
        $result = $this->getTopicDao()->get(1);

        $this->assertEquals(2, $result['followNum']);
    }

    /**
     * @expectedException Exception
     */
    public function testFollowTopicWithException()
    {
        $this->getFollowTopicService()->followTopic(1);

        $result = $this->getFollowTopicService()->getFollowTopicByUserIdAndTopicId(1, 1);

        $this->assertEquals(1, $result[0]['userId']);
        $this->assertEquals(1, $result[0]['objectId']);
    }

    /**
     * @expectedException Exception
     */
    public function testUnFollowTopicWithException()
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

    protected function getTopicDao()
    {
        return self::$kernel['topic_dao'];
    }

    protected function getFollowTopicDao()
    {
        return self::$kernel['follow_topic_dao'];
    }
}