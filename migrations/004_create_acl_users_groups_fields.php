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
            'is_editable'    => ['type' => 'smallint'],
            'is_required'    => ['type' => 'smallint'],
            'default_values' => ['type' => 'text', 'null' => true],
            'created_at'     => ['type' => 'int'],
            'created_by'     => ['type' => 'int'],
            'updated_at'     => ['type' => 'int', 'null' => true],
            'updated_by'     => ['type' => 'int', 'null' => true],
                ], ['id'], true, false, false);
        
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
