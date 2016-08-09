<?php

namespace Topxia\Service\Topic\Tests;

use Topxia\Service\Topic\Impl\TopicServiceImpl;

class TopicServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFindAllTopics()
    {
        $TopicServiceImpl = new TopicServiceImpl();
        $topic = array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
            );
        $topic = $TopicServiceImpl->createTopic($topic);
        $result = $TopicServiceImpl->getTopic($topic['id']);
        /*array(
            'name' => 'sql',
            'createdTime' => time(),
            'userId' => '1'
            );*/
        $this->assertEquals($topic['name'], $result['name']);
        $this->assertEquals($topic['createdTime'], $result['createdTime']);
        $this->assertEquals($topic['userId'], $result['userId']);
    }
}