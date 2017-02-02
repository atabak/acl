<?php

namespace Fuel\Migrations;

class Create_acl_users_groups
{

    protected $table = 'acl_users_groups';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'   => array('type' => 'int', 'auto_increment' => true),
            'name' => array('constraint' => 256, 'type' => 'varchar'),
                ), array('id'), true, false, false);
        \DBUtil::add_foreign_key('acl_users', array(
            'key'       => 'group_id',
            'reference' => array(
                'table'  => $this->table,
                'column' => 'id',
            ),
        ));
        \DB::insert()
                ->table($this->table)
                ->columns(array('name'))
                ->values(array(array('مدیر سیستم')))
                ->execute();
        // create new user
        \DB::insert()
                ->table('acl_users')
                ->columns(array('username', 'email', 'password', 'group_id', 'is_active', 'is_confirm', 'unsuccess', 'remember', 'is_locked', 'lock_at'))
                ->values(array(array('admin', 'atabak.h@gmail.com', \Acl\Acl::password_hash('Data@123'), 1, 1, 1, 0, '', 0, 0)))
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key('acl_users_groups', 'acl_users');
        \DBUtil::drop_table($this->table);
    }

}
