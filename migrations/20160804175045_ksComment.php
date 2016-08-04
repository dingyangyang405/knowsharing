<?php

use Phpmig\Migration\Migration;

class KsComment extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('comment');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('value', 'string', array('null' => false, 'comment' => '评论内容'));
        $table->addColumn('knowledge_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '知识id'));
        $table->addColumn('user_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '用户id'));
        $table->addColumn('create_date', 'date', array('null' => false, 'comment' => '评论日期日期'));

        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('comment');
    }
}
