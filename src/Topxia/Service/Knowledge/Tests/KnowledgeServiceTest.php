<?php

namespace Topxia\Service\Knowledge\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class KnowledgeServiceTest extends BaseTestCase
{
    public function testGetKnowledgesCount()
    {   
        $knowledge1 = array(
            'title' => 1,
            'userId' => 1,
            'createdTime' => '1464591741'
        );
        $knowledge2 = array(
            'title' => 1,
            'userId' => 1,
            'createdTime' => '1464591742'
        );
        $this->getKnowledgeService()->createKnowledge($knowledge1);
        $this->getKnowledgeService()->createKnowledge($knowledge2);
        $ids           = array(
            $knowledge1['id'] = 1,
            $knowledge2['id'] = 2
        );

        $count = $this->getKnowledgeService()->getKnowledgesCount($ids);
        $this->assertEquals(2, $count);
    }

    public function testUpdate()
    {
        $knowledge = array(
            'title' => '测试１',
            'summary' => '测试1',
            'type' => 'file',
            'topicId' => 1,
            'userId' => 1,
            'createdTime' => 2016810,
            'updatedTime' => 2016811,
            'content' => '这是测试1',
            'favoriteNum' => 10,
            'likeNum' => 10
        );
        $knowledge = $this->getKnowledgeService()->createKnowledge($knowledge);
        $updateKnowledge = array(
            'title' => '测试2',
            'summary' => '测试2',
            'type' => 'file',
            'topicId' => 1,
            'userId' => 1,
            'createdTime' => 2016810,
            'updatedTime' => 2016811,
            'content' => '这是测试2',
            'favoriteNum' => 10,
            'likeNum' => 10
        );
        $updatedKnowledge = $this->getKnowledgeService()->updateKnowledge(1,$updateKnowledge);
        $this->assertEquals($updateKnowledge,$updatedKnowledge);
    }

    public function testDeleteKnowledge()
    {
        $knowledge = array(
            'title' => '测试１',
            'summary' => '测试1',
            'type' => 'file',
            'themedId' => 1,
            'userId' => 1,
            'createdTime' => 2016810,
            'updatedTime' => 2016811,
            'content' => '这是测试1',
            'favoriteNum' => 10,
            'likeNum' => 10
        ); 
        $knowledged = $this->getKnowledgeService()->createKnowledge($knowledge);
        $result = $this->getKnowledgeService()->delete($knowledged['id']);
        $knowledge = $this->getKnowledgeService()->get($knowledged['id']);
        $this->assertEquals(1,$result);
        $this->assertFalse($knowledge);
        $result = $this->getKnowledgeService()->delete($knowledged['id']);
        $this->assertEquals(0,$result);
    }

    public function testAddKnowledge()
    {
        $data = array(
            'title' => 'title',
            'summary' => 'summary',
            'content' => 'content',
            'type' => 'file',
            'userId' => 1,
        );
        $knowledge = $this->getKnowledgeService()->add($data);
        $result = $this->getKnowledgeService()->get($knowledge['id']);

        $this->assertEquals($knowledge['title'], $result['title']);
        $this->assertEquals($knowledge['summary'], $result['summary']);
        $this->assertEquals($knowledge['content'], $result['content']);
        $this->assertEquals($knowledge['type'], $result['type']);
        $this->assertEquals($knowledge['userId'], $result['userId']);
    }

    protected function getKnowledgeService()
    {
        return self::$kernel['knowledge_service'];
    }
}