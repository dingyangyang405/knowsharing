<?php

use Phpmig\Migration\Migration;

class KsTheme extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('theme');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('name', 'string', array('length' => 10, 'null' => false, 'comment' => '主题名字'));
        $table->addColumn('create_date', 'date', array('null' => false, 'comment' => '创建日期'));
        $table->addColumn('user_id', 'integer', array('unsigned' => true, 'null' => false, 'comment' => '创建者id'));

        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('theme');
    }
}