<?php

namespace Fuel\Migrations;

class Create_acl_users_modules_controllers_actions
{

    protected $table = 'acl_users_modules_controllers_actions';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'            => array('type' => 'int', 'auto_increment' => true),
            'controller_id' => array('type' => 'int'),
            'name'          => array('constraint' => 512, 'type' => 'varchar'),
            'uri'           => array('constraint' => 256, 'type' => 'varchar'),
            'order'         => array('type' => 'int'),
            'is_active'     => array('type' => 'bool'),
            'is_visible'    => array('type' => 'bool', 'default' => 1),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'controller_id', 'controller_id');
        \DBUtil::create_index($this->table, 'order', 'order');
        \DBUtil::create_index($this->table, 'is_active', 'is_active');
        \DBUtil::create_index($this->table, 'uri', 'uri', 'fulltext');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'controller_id',
            'reference' => array(
                'table'  => 'acl_users_modules_controller',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DB::insert()
                ->table($this->table)
                ->columns(array('controller_id', 'name', 'uri', 'order', 'is_active', 'is_visible'))
                ->values(array(
                    array(1, 'ایجاد کاربر', 'create', 1, 1, 1),
                    array(1, 'ویرایش کاربر', 'edit', 3, 1, 0),
                    array(1, 'تایید کاربران', 'confirmusr', 3, 1, 0),
                    array(1, 'جستجو', 'search', 1, 1, 1),
                    array(2, 'مدیریت گروه ها', 'index.html', 1, 1, 1),
                    array(2, 'مدیریت فیلد ها', 'fields.html', 2, 1, 1),
                    array(3, 'ماژول', 'modules', 1, 1, 1),
                    array(3, 'کلاس ها', 'controller', 2, 1, 1),
                    array(3, 'توابع', 'actions', 3, 1, 1),
                        )
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'controller_id');
        \DBUtil::drop_table($this->table);
    }

}
