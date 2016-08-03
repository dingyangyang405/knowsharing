<?php

use Phpmig\Migration\Migration;

class User extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();

        $table = new Doctrine\DBAL\Schema\Table('user');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('name', 'string', array('length' => 100, 'null' => false, 'comment' => '用户姓名'));
        $table->addColumn('updated', 'integer', array('default' => 0, 'signed' => true));
        $table->addColumn('created', 'integer', array('default' => 0, 'signed' => true));
        $table->setPrimaryKey(array('id'));

        $container['db']->getSchemaManager()->createTable($table);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $container = $this->getContainer();
        $container['db']->getSchemaManager()->dropTable('user');
    }
}
