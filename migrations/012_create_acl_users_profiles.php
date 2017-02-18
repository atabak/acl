<?php

namespace Fuel\Migrations;

class Create_acl_users_profiles
{

    protected $table = 'acl_users_profiles';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'          => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'user_id'     => ['type' => 'int'],
            'first'       => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'last'        => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'pic'         => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'cell'        => ['type' => 'varchar', 'constraint' => 254, 'null' => true],
            'created_at'  => ['type' => 'int'],
            'created_by'  => ['type' => 'int'],
            'updated_at'  => ['type' => 'int', 'null' => true],
            'updated_by'  => ['type' => 'int', 'null' => true],
            'confirm_at'  => ['type' => 'int', 'null' => true],
            'confirm_by'  => ['type' => 'int', 'null' => true],
            'locked_at'   => ['type' => 'int', 'null' => true],
            'unlocked_at' => ['type' => 'int', 'null' => true],
            'unlocked_by' => ['type' => 'int', 'null' => true],
                ], ['id'], true, false, false);
        \DBUtil::create_index($this->table, 'user_id', 'acl_users_profiles_user_id');
        \DBUtil::create_index($this->table, 'created_by', 'acl_users_profiles_created_by');
        \DBUtil::create_index($this->table, 'updated_by', 'acl_users_profiles_updated_by');
        \DBUtil::create_index($this->table, 'confirm_by', 'acl_users_profiles_confirm_by');
        \DBUtil::create_index($this->table, 'unlocked_by', 'acl_users_profiles_unlocked_by');
        \DBUtil::add_foreign_key($this->table, ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key($this->table, ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'updated_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'confirm_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key($this->table, ['key' => 'unlocked_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DB::insert()
                ->table($this->table)
                ->columns(['user_id', 'first', 'last', 'cell', 'pic', 'created_at', 'created_by', 'confirm_at', 'confirm_by'])
                ->values([[1, 'اتابک', 'حسین نیا', '09354303475', '', \Myclasses\FNC::currentdbtime(), 1, \Myclasses\FNC::currentdbtime(), 1]])
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_foreign_key($this->table, 'user_id');
        \DBUtil::drop_foreign_key($this->table, 'created_by');
        \DBUtil::drop_foreign_key($this->table, 'updated_by');
        \DBUtil::drop_foreign_key($this->table, 'confirm_by');
        \DBUtil::drop_foreign_key($this->table, 'unlocked_by');
        \DBUtil::drop_table($this->table);
    }

}
