<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class ToDoListServiceTest extends BaseTestCase
{
    public function testFindToDoListByUserId()
    {
        $field1 = array(
            'userId' => 1,
            'knowledgeId' => 1
        );

        $field2 = array(
            'userId' => 1,
            'knowledgeId' => 2
        );

        $this->getToDoListDao()->create($field1);
        $this->getToDoListDao()->create($field2);

        $result = $this->getToDoListService()->findToDoListByUserId('1');
        $this->assertEquals(2,count($result));
    }

    protected function getToDoListService()
    {
        return self::$kernel['todolist_service'];
    }

    protected function getToDoListDao()
    {
        return self::$kernel['todolist_dao'];
    }
}
