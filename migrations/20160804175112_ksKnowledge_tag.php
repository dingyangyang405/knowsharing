<?php

use Phpmig\Migration\Migration;

class KsKnowledgeTag extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('knowledge_tag');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('knowledge_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '知识id'));
        $table->addColumn('tag_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '标签id'));
        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('knowledge_tag');
    }   
}
