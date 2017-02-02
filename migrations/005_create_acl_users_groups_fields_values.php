<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields_values
{

    protected $table = 'acl_users_groups_fields_values';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'         => array('type' => 'int', 'auto_increment' => true),
            'user_id'    => array('type' => 'int'),
            'field_id'   => array('type' => 'int'),
            'value'      => array('type' => 'text'),
            'created_at' => array('type' => 'int'),
            'created_by' => array('type' => 'int'),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'user_id', 'user_id');
        \DBUtil::create_index($this->table, 'field_id', 'field_id');
        \DBUtil::create_index($this->table, 'created_by', 'created_by');
        \DBUtil::create_index($this->table, 'value', 'value', 'fulltext');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'user_id',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'field_id',
            'reference' => array(
                'table'  => 'acl_users_groups_fields',
                'column' => 'id',
            ),
            'on_delete' => 'CASCADE'
        ));
        \DBUtil::add_foreign_key('acl_users_groups_fields', array(
            'key'       => 'created_by',
            'reference' => array(
                'table'  => 'acl_users',
                'column' => 'id',
            ),
        ));
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'field_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_table($this->table);
    }

}
