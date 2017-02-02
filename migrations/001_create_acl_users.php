<?php

namespace Fuel\Migrations;

class Create_acl_users
{

    protected $table = 'acl_users';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'         => array('type' => 'int', 'auto_increment' => true),
            'username'   => array('constraint' => 256, 'type' => 'varchar'),
            'email'      => array('constraint' => 256, 'type' => 'varchar', 'null' => true),
            'password'   => array('constraint' => 512, 'type' => 'varchar'),
            'group_id'   => array('type' => 'int'),
            'is_active'  => array('type' => 'bool'),
            'is_confirm' => array('type' => 'bool'),
            'unsuccess'  => array('type' => 'int', 'default' => 0),
            'remember'   => array('constraint' => 512, 'type' => 'varchar', 'default' => ''),
            'is_locked'  => array('type' => 'bool', 'default' => 0),
            'lock_at'    => array('type' => 'int', 'default' => 0),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'username', 'username', 'UNIQUE');
        \DBUtil::create_index($this->table, 'email', 'email', 'UNIQUE');
        \DBUtil::create_index($this->table, 'group_id', 'group_id');
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
