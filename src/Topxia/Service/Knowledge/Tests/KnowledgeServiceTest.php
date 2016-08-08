<?php

namespace Topxia\Service\Knowledge\Tests;

use Topxia\Service\Knowledge\Impl\KnowledgeServiceImpl;

class KnowledgeServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testAddKnowledge()
    {
        $KnowledgeServiceImpl = new KnowledgeServiceImpl();
        $data = array(
            'title' => 'title',
            'summary' => 'summary',
            'content' => 'content',
            'type' => 'file',
            'userId' => 1,
        );
        $knowledge = $KnowledgeServiceImpl->addKnowledge($data);
        $result = $KnowledgeServiceImpl->getKnowledgeDetial($data['id']);
        
        $this->assertEquals($knowledge['title'], $result['title']);
        $this->assertEquals($knowledge['summary'], $result['summary']);
        $this->assertEquals($knowledge['content'], $result['content']);
        $this->assertEquals($knowledge['type'], $result['type']);
        $this->assertEquals($knowledge['userId'], $result['userId']);
    }
}