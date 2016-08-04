<?php

use Phpmig\Migration\Migration;

class KsUser extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $container = $this->getContainer();
        $table = new Doctrine\DBAL\Schema\Table('user');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement'=> true));
        $table->addColumn('name', 'string', array('length' => 10, 'null' => false, 'comment' => '用户名'));
        $table->addColumn('role', 'string', array('length' => 10, 'null' => false, 'comment' => '角色'));
        $table->addColumn('icon', 'text', array('comment' => '头像'));
        $table->addColumn('mobile_No', 'string', array('length' => 20, 'comment' => '手机号'));
        $table->addColumn('password', 'string', array('null' => false, 'length' => 20, 'comment' => '密码'));
        $table->addColumn('email', 'string', array('null' => false, 'length' => 20, 'comment' => '邮箱'));
        $table->setPrimaryKey(array('id'));
        var_dump(1111);
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
