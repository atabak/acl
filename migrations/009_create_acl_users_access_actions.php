<?php

namespace Fuel\Migrations;

class Create_acl_users_access_actions
{

    protected $table = 'acl_users_access_actions';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'        => array('type' => 'int', 'auto_increment' => true),
            'user_id'   => array('type' => 'int'),
            'action_id' => array('type' => 'int'),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'action_id', 'action_id');
        \DBUtil::create_index($this->table, 'user_id', 'user_id');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'action_id',
            'reference' => array(
                'table'  => 'acl_users_modules_controllers_actions',
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
                ->columns(array('user_id', 'action_id'))
                ->values(array(
                    array(1, 1),
                    array(1, 2),
                    array(1, 3),
                    array(1, 4),
                    array(1, 5),
                    array(1, 6),
                    array(1, 7),
                    array(1, 8),
                    array(1, 9),
                        )
                )
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'action_id');
        \DBUtil::drop_table($this->table);
    }

}
