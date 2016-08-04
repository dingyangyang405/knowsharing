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
        $table->addColumn('title', 'string', array('length' => 10, 'null' => false, 'comment' => '标题'));
        $table->addColumn('summary', 'text', array('comment' => '摘要'));
        $table->addColumn('type', 'string', array('length' => 10, 'null' => false, 'comment' => '分享类型'));
        $table->addColumn('theme_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '主题id'));
        $table->addColumn('like_num', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '点赞总数'));
        $table->addColumn('collect_num', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '收藏总数'));
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