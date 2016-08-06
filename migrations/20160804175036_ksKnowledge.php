<?php

use Phpmig\Migration\Migration;

class KsKnowledge extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('knowledge');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('title', 'string', array('length' => 10, 'null' => true, 'comment' => '标题'));
        $table->addColumn('summary', 'text', array('comment' => '摘要'));
        $table->addColumn('type', 'string', array('length' => 10, 'null' => false, 'comment' => '分享类型'));
        $table->addColumn('themeId', 'integer', array('unsigned' => true, 'comment' => '主题id'));
        $table->addColumn('userId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '创建者id'));
        $table->addColumn('createdTime', 'integer', array('null' => false, 'comment' => '创建日期'));
        $table->addColumn('updatedTime', 'integer', array('comment' => '修改日期'));
        $table->addColumn('content', 'string', array('length' => 60, 'null' => false, 'comment' => '内容'));
        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('knowledge');
    }
}
