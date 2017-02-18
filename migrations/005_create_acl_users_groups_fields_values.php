<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields_values
{

    protected $table = 'acl_users_groups_fields_values';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'         => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'    => ['type' => 'int'],
            'field_id'   => ['type' => 'int'],
            'value'      => ['type' => 'text'],
            'created_at' => ['type' => 'int'],
            'created_by' => ['type' => 'int'],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'user_id', 'acl_users_groups_fields_values_user_id');
        \DBUtil::create_index($this->table, 'field_id', 'acl_users_groups_fields_values_field_id');
        \DBUtil::create_index($this->table, 'created_by', 'acl_users_groups_fields_values_created_by');
        \DBUtil::create_index($this->table, 'value', 'acl_users_groups_fields_values_value');
        \DBUtil::add_foreign_key($this->table, ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'field_id', 'reference' => ['table' => 'acl_users_groups_fields', 'column' => 'id'], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'field_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'acl_users_groups_fields_values_value');
        \DBUtil::drop_table($this->table);
    }

}
