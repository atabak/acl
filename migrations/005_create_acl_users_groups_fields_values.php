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
