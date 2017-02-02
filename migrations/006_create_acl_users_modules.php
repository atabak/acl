<?php

namespace Fuel\Migrations;

class Create_acl_users_modules
{

    protected $table = 'acl_users_modules';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'        => array('type' => 'int', 'auto_increment' => true),
            'name'      => array('constraint' => 512, 'type' => 'varchar'),
            'url'       => array('constraint' => 256, 'type' => 'varchar'),
            'order'     => array('type' => 'int'),
            'icon'      => array('constraint' => 45, 'type' => 'varchar'),
            'color'     => array('constraint' => 45, 'type' => 'varchar', 'null' => true),
            'is_active' => array('type' => 'bool', 'default' => 1),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'url', 'url');
        \DBUtil::create_index($this->table, 'order', 'order');
        \DBUtil::create_index($this->table, 'is_active', 'is_active');
        \DB::insert()
                ->table($this->table)
                ->columns(array('name', 'url', 'order', 'icon', 'color', 'is_active'))
                ->values(array(array('مدیریت کاربران', 'dashboard/users', 1000, 'fa-user', '', 1)))
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
