<?php

namespace Fuel\Migrations;

class Create_acl_users_profiles
{

    protected $table = 'acl_users_profiles';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'          => array('type' => 'int', 'auto_increment' => true),
            'user_id'     => array('type' => 'int'),
            'first'       => array('constraint' => 256, 'type' => 'varchar', 'null' => true),
            'last'        => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'pic'         => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'cell'        => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'created_at'  => array('type' => 'int'),
            'created_by'  => array('type' => 'int'),
            'updated_at'  => array('type' => 'int', 'null' => true),
            'updated_by'  => array('type' => 'int', 'null' => true),
            'confirm_at'  => array('type' => 'int', 'null' => true),
            'confirm_by'  => array('type' => 'int', 'null' => true),
            'locked_at'   => array('type' => 'int', 'null' => true),
            'unlocked_at' => array('type' => 'int', 'null' => true),
            'unlocked_by' => array('type' => 'int', 'null' => true),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'user_id', 'user_id');
        \DBUtil::create_index($this->table, 'created_by', 'created_by');
        \DBUtil::create_index($this->table, 'updated_by', 'updated_by');
        \DBUtil::create_index($this->table, 'confirm_by', 'confirm_by');
        \DBUtil::create_index($this->table, 'unlocked_by', 'unlocked_by');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'user_id',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'created_by',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'updated_by',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'confirm_by',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'unlocked_by',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
        ));
        \DB::insert()
                ->table($this->table)
                ->columns(array('user_id', 'first', 'last', 'cell', 'pic', 'created_at', 'created_by', 'confirm_at', 'confirm_by'))
                ->values(array(array(1, 'اتابک', 'حسین نیا', '09354303475', '', \Myclasses\FNC::currentdbtime(), 1, \Myclasses\FNC::currentdbtime(), 1)))
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'acl_users');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'updated_by');
        \DBUtil::drop_foreign_key($this->table, 'confirm_by');
        \DBUtil::drop_foreign_key($this->table, 'unlocked_by');
        \DBUtil::drop_table($this->table);
    }

}
