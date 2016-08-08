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
        $this->knowledgeServiceImpl = static::$kernel->getContainer()->get('knowledge_service');
    }
    public function testFindKnowledges()
    {
        $this->assertEquals('default', $this->knowledgeServiceImpl->getKnowledgeDetial(1));
    }
}