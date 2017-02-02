<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields
{

    protected $table = 'acl_users_groups_fields';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'             => array('type' => 'int', 'auto_increment' => true),
            'group_id'       => array('type' => 'int'),
            'label'          => array('type' => 'varchar', 'constraint' => 256),
            'type_id'        => array('type' => 'int'),
            'order'          => array('type' => 'int'),
            'size'           => array('type' => 'int'),
            'is_editable'    => array('type' => 'bool', 'default' => 0),
            'is_required'    => array('type' => 'bool', 'default' => 0),
            'default_values' => array('type' => 'text', 'null' => true),
            'created_at'     => array('type' => 'int'),
            'created_by'     => array('type' => 'int'),
            'updated_at'     => array('type' => 'int', 'null' => true),
            'updated_by'     => array('type' => 'int', 'null' => true),
                ), array('id'), true, false, false);
        \DBUtil::create_index($this->table, 'group_id', 'group_id');
        \DBUtil::create_index($this->table, 'type_id', 'type_id');
        \DBUtil::create_index($this->table, 'order', 'order');
        \DBUtil::create_index($this->table, 'created_by', 'created_by');
        \DBUtil::create_index($this->table, 'updated_by', 'updated_by');
        \DBUtil::create_index($this->table, 'default_values', 'default_values', 'fulltext');
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'group_id',
            'reference' => array(
                'table'  => 'acl_users_groups',
                'column' => 'id',
            ),
        ));
        \DBUtil::add_foreign_key($this->table, array(
            'key'       => 'type_id',
            'reference' => array(
                'table'  => 'acl_users_groups_fields_type',
                'column' => 'id',
            ),
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
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'group_id');
        \DBUtil::drop_foreign_key($this->table, 'type_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'updated_by');
        \DBUtil::drop_table($this->table);
    }

}
