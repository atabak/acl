<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controller
{

    protected $table = 'acl_users_modules_controller';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'        => array('type' => 'int', 'auto_increment' => true),
            'module_id' => array('type' => 'int'),
            'name'      => array('constraint' => 512, 'type' => 'varchar'),
            'url'       => array('constraint' => 256, 'type' => 'varchar'),
            'order'     => array('type' => 'int'),
            'is_active' => array('type' => 'bool', 'default' => 1),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'module_id', 'module_id');
        \DBUtil::create_index($this->table, 'url', 'url');
        \DBUtil::create_index($this->table, 'order', 'order');
        \DBUtil::create_index($this->table, 'is_active', 'is_active');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'module_id',
            'reference' => array(
                'table'  => 'acl_users_modules',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DB::insert()
                ->table($this->table)
                ->columns(array('module_id', 'name', 'url', 'order', 'is_active'))
                ->values(array(
                    array(1, 'کاربران', 'user', 1, 1),
                    array(1, 'مدیریت گروه های کاربری', 'groups', 1, 1),
                    array(1, 'مدیریت دسترسی ها', 'access', 1, 1),
                        )
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'module_id');
        \DBUtil::drop_table($this->table);
    }

}
