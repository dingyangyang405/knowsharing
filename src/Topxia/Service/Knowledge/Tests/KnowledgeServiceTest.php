<?php

namespace Topxia\Service\Knowledge\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KnowledgeServiceTest extends WebTestCase
{
    private $knowledgeServiceImpl;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $startKernel = static::$kernel->getContainer()->get('biz_kernel');
        $this->knowledgeServiceImpl = $startKernel['knowledge_service'];
    }

    public function testDetail()
    {
            $this->assertEquals('default', $this->knowledgeServiceImpl->getKnowledgeDetial(1));
    }

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