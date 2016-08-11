<?php

namespace Topxia\Service\Knowledge\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class KnowledgeServiceTest extends BaseTestCase
{
    public function testGetKnowledgeCount()
    {   
        $fields =　array (
            0 => array ( 
                'title' => '测试１',
                'summary' => '测试',
                'type' => 'file',
                'themedId' => 1,
                'userId' => 1,
                'createdTime' => 2016810,
                'updatedTime' => 2016811,
                'content' => '这是测试',
                'favoriteNum' => 10,
                'likeNum' => 10
            ),
            1 => array (
                'title' => '测试2',
                'summary' => '测试',
                'type' => 'link',
                'themedId' => 1,
                'userId' => 1,
                'createdTime' => 2016810,
                'updatedTime' => 2016811,
                'content' => '这是测试',
                'favoriteNum' => 10,
                'likeNum' => 10  
            )

        );
        $this->getKnowledgeService()->add($fields[0]);
        $this->getKnowledgeService()->add($fields[1]);
        $count = getKnowledgeService()->getKnowledgeCount('userId' => 1);
        $this->assertEquals(2, $count);
    }

    public function testUpdate()
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
        $knowledged = $this->getKnowledgeService()->add($knowledge);
        $updateKnowledge = array(
            'title' => '测试2',
            'summary' => '测试2',
            'type' => 'file',
            'themedId' => 1,
            'userId' => 1,
            'createdTime' => 2016810,
            'updatedTime' => 2016811,
            'content' => '这是测试2',
            'favoriteNum' => 10,
            'likeNum' => 10
        );
        $updatedKnowledge = $this->getKnowledgeService()->update($knowledged['id'],$updateKnowledge);
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
        $knowledged = $this->getKnowledgeService()->add($knowledge);
        $result = $this->getKnowledgeService()->delete($knowledged['id']);
        $knowledge = $this->getKnowledgeService()->get($knowledged['id']);
        $this->assertEquals(1,$result);
        $this->assertFalse($knowledge);
        $result = $this->getKnowledgeService()->delete($knowledged['id']);
        $this->assertEquals(0,$result);

    public function testAddKnowledge()
    {
        $data = array(
            'title' => 'title',
            'summary' => 'summary',
            'content' => 'content',
            'type' => 'file',
            'userId' => 1,
        );
        $knowledge = $this->getKnowledgeService()->addKnowledge($data);
        $result = $this->getKnowledgeService()->getKnowledgeDetial($data['id']);

        $this->assertEquals($knowledge['title'], $result['title']);
        $this->assertEquals($knowledge['summary'], $result['summary']);
        $this->assertEquals($knowledge['content'], $result['content']);
        $this->assertEquals($knowledge['type'], $result['type']);
        $this->assertEquals($knowledge['userId'], $result['userId']);
    }

    protected function getKnowledgeService()
    {
        return self::$kernel['biz']['knowledge_service'];
    }
}