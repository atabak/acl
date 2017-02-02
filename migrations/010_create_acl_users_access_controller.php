<?php

namespace Fuel\Migrations;

class Create_acl_users_access_controller
{

    protected $table = 'acl_users_access_controller';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'            => array('type' => 'int', 'auto_increment' => true),
            'user_id'       => array('type' => 'int'),
            'controller_id' => array('type' => 'int'),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'controller_id', 'controller_id');
        \DBUtil::create_index($this->table, 'user_id', 'user_id');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'controller_id',
            'reference' => array(
                'table'  => 'acl_users_modules_controller',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'user_id',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DB::insert()
                ->table($this->table)
                ->columns(array('user_id', 'controller_id'))
                ->values(array(
                    array(1, 1),
                    array(1, 2),
                    array(1, 3),
                        )
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'controller_id');
        \DBUtil::drop_table($this->table);
    }

}
