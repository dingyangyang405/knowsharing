<?php

namespace Topxia\Service\Topic\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;
use Topxia\Common\ArrayToolKit;

class TopicServiceTest extends BaseTestCase
{
    public function testCreateTopic()
    {
        $topic = array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
        );
        $topic = $this->getTopicService()->createTopic($topic);
        $result = ArrayToolKit::index($this->getTopicService()->findAllTopics($topic['id']),'id');

        $this->assertEquals($topic['name'], $result[1]['name']);
        $this->assertEquals($topic['createdTime'], $result[1]['createdTime']);
        $this->assertEquals($topic['userId'], $result[1]['userId']);
    }

    public function testFindAllTopics()
    {
        $topic1 = array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
        );
        $topic2 = array(
            'name' => 'sql1',
            'createdTime' => time(),
            'userId' => '2'
        );
        $topic3 = array(
            'name' => 'sql1',
            'createdTime' => time(),
            'userId' => '3'
        );
        $topic = $this->getTopicService()->createTopic($topic1);
        $topic = $this->getTopicService()->createTopic($topic2);
        $topic = $this->getTopicService()->createTopic($topic3);
        $result = ArrayToolKit::index($this->getTopicService()->findAllTopics($topic['id']),'id');

        $this->assertEquals(3, count($result));
    }

    protected function getTopicService()
    {
        return self::$kernel['topic_service'];
    }
}