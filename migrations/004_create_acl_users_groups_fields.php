<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields
{

    protected $table = 'acl_users_groups_fields';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'             => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'group_id'       => ['type' => 'int'],
            'label'          => ['type' => 'varchar', 'constraint' => 256],
            'type_id'        => ['type' => 'int'],
            'order'          => ['type' => 'int'],
            'size'           => ['type' => 'int'],
            'is_editable'    => ['type' => 'bool', 'default' => false],
            'is_required'    => ['type' => 'bool', 'default' => false],
            'default_values' => ['type' => 'text', 'null' => true],
            'created_at'     => ['type' => 'int'],
            'created_by'     => ['type' => 'int'],
            'updated_at'     => ['type' => 'int', 'null' => true],
            'updated_by'     => ['type' => 'int', 'null' => true],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'group_id', 'acl_users_groups_fields_group_id');
        \DBUtil::create_index($this->table, 'type_id', 'acl_users_groups_fields_type_id');
        \DBUtil::create_index($this->table, 'order', 'acl_users_groups_fields_order');
        \DBUtil::create_index($this->table, 'created_by', 'acl_users_groups_fields_created_by');
        \DBUtil::create_index($this->table, 'updated_by', 'acl_users_groups_fields_updated_by');
        \DBUtil::create_index($this->table, 'default_values', 'field_default_values');
        \DBUtil::add_foreign_key($this->table, ['key' => 'group_id', 'reference' => ['table' => 'acl_users_groups', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'type_id', 'reference' => ['table' => 'acl_users_groups_fields_type', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'updated_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
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
