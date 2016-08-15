<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class ToreadDaoTest extends BaseTestCase
{
    public function testGetToreadByUserIdAndKnowledgeId()
    {
        $record = array(
            'userId' => 1,
            'knowledgeId' => 1,
        );
        $this->getToreadDao()->create($record);

        $result = $this->getToreadDao()->getToreadByUserIdAndKnowledgeId($record);

        $this->assertEquals(1, $result['userId']);
        $this->assertEquals(1, $result['knowledgeId']);
    }

    public function testFindToreadIds()
    {
        $record = array();
        for ($index = 0; $index < 3; $index++) { 
            $record['userId'] = 1;
            $record['knowledgeId'] = $index;
            $this->getToreadDao()->create($record);
        }

        $result = $this->getToreadDao()->findToreadIds(1);
        $this->assertEquals(3, count($result));

        $result = $this->getToreadDao()->findToreadIds(2);
        $this->assertEquals(0, count($result));
    }

    protected function getToreadDao()
    {
        return self::$kernel['toread_dao'];
    }
}