<?php

namespace Topxia\Service\Knowledge\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class KnowledgeServiceTest extends BaseTestCase
{
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