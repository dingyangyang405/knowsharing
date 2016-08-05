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
        $table->addColumn('themeId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '主题id'));
        $table->addColumn('likeNum', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '点赞总数'));
        $table->addColumn('collectNum', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '收藏总数'));
        $table->addColumn('ownerId', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '创建者id'));
        $table->addColumn('createdTime', 'integer', array('null' => false, 'comment' => '创建日期'));
        $table->addColumn('updateTime', 'integer', array('null' => false, 'comment' => '修改日期'));
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
