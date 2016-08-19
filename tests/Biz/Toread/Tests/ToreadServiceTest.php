<?php

use Codeages\Biz\Framework\UnitTests\BaseTestCase;

class ToreadServiceTest extends BaseTestCase
{
    public function testCreateToreadKnowledge()
    {
        $knowledge = array(
            'title' => '21天精通ｐｈｐ',
            'summary' => '简洁的摘要',
            'content' => '没什么内容',
            'type' => 'file',
            'userId' => 1,
        );
        $this->getKnowledgeDao()->create($knowledge);
        $this->getToreadService()->createToreadKnowledge(1, 1);
        $result = $this->getToreadDao()->get(1);

        $this->assertEquals(1, $result['userId']);
        $this->assertEquals(1, $result['knowledgeId']);
    }

    public function testDeleteToreadKnowledge()
    {
        $knowledge = array(
            'title' => '21天精通ｐｈｐ',
            'summary' => '简洁的摘要',
            'content' => '没什么内容',
            'type' => 'file',
            'userId' => 1,
        );
        $this->getKnowledgeDao()->create($knowledge);
        $this->getToreadService()->createToreadKnowledge(1, 1);

        $this->getToreadService()->deleteToreadKnowledge(1, 1);

        $result = $this->getToreadDao()->get(1);

        $this->assertEquals(null, $result);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateToreadKnowledgeWithNoKnowledgeException()
    {
        $this->getToreadService()->createToreadKnowledge(1, 1);

        $result = $this->getToreadDao()->get(1);

        $this->assertEquals(1, $result['userId']);
        $this->assertEquals(1, $result['knowledgeId']);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateToreadKnowledgeWithRecordRepeatException()
    {
        $knowledge = array(
            'title' => '21天精通ｐｈｐ',
            'summary' => '简洁的摘要',
            'content' => '没什么内容',
            'type' => 'file',
            'userId' => 1,
        );
        $this->getKnowledgeDao()->create($knowledge);
        $this->getToreadService()->createToreadKnowledge(1, 1);
        $this->getToreadService()->createToreadKnowledge(1, 1);

        $this->assertEquals(1, $result['userId']);
        $this->assertEquals(1, $result['knowledgeId']);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteToreadKnowledgeWithNoKnowledgeException()
    {
        $this->getToreadService()->createToreadKnowledge(1, 1);

        $this->getToreadService()->deleteToreadKnowledge(1, 1);

        $result = $this->getToreadDao()->get(1);

        $this->assertEquals(null, $result);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateToreadKnowledgeWithNoRecordException()
    {
        $this->getToreadService()->deleteToreadKnowledge(1, 1);

        $result = $this->getToreadDao()->get(1);

        $this->assertEquals(null, $result);
    }

    public function testGetToreadlistCount()
    {
        $knowledge = array(
            'title' => '21天精通ｐｈｐ',
            'summary' => '简洁的摘要',
            'content' => '没什么内容',
            'type' => 'file',
            'userId' => 1,
        );
        $this->getKnowledgeDao()->create($knowledge);
        $this->getToreadService()->createToreadKnowledge(1, 1);

        $result = $this->getToreadService()->getToreadlistCount(array('userId' => 1));

        $this->assertEquals(1, $result);
    }

    protected function getToreadService()
    {
        return self::$kernel['toread_service'];
    }

    protected function getToreadDao()
    {
        return self::$kernel['toread_dao'];
    }

    protected function getKnowledgeDao()
    {
        return self::$kernel['knowledge_dao'];
    }
}