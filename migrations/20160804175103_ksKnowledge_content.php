<?php

use Phpmig\Migration\Migration;

class KsKnowledgeContent extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('knowledge_content');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('knowledgeId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '知识id'));
        $table->addColumn('type', 'string', array('length' => 10, 'null' => false, 'comment' => '分享类型'));
        $table->addColumn('content', 'blob', array('null' => false, 'comment' => '内容'));
        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('knowledge_content');
    }
}
