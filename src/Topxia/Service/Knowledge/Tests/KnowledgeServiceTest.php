<?php

namespace Topxia\Service\Knowledge\Tests;

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class KnowledgeServiceTest extends BaseTestCase
{
    public function testDetail()
    {
            $data = $this->getKnowledgeService()->getKnowledgeDetial(1);
            $this->assertNull($data);
    }

//    public function testAddKnowledge()
//    {
//        $KnowledgeServiceImpl = new KnowledgeServiceImpl();
//        $data = array(
//            'title' => 'title',
//            'summary' => 'summary',
//            'content' => 'content',
//            'type' => 'file',
//            'userId' => 1,
//        );
//        $knowledge = $KnowledgeServiceImpl->addKnowledge($data);
//        $result = $KnowledgeServiceImpl->getKnowledgeDetial($data['id']);
//
//        $this->assertEquals($knowledge['title'], $result['title']);
//        $this->assertEquals($knowledge['summary'], $result['summary']);
//        $this->assertEquals($knowledge['content'], $result['content']);
//        $this->assertEquals($knowledge['type'], $result['type']);
//        $this->assertEquals($knowledge['userId'], $result['userId']);
//    }

    protected function getKnowledgeService()
    {
        return self::$kernel['knowledge_service'];
    }
}