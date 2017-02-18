<?php

namespace Fuel\Migrations;

class Create_acl_users_groups
{

    protected $table = 'acl_users_groups';

    public function up()
    {
        \DBUtil::create_table($this->table, [
            'id'   => ['type' => 'int', 'AUTO_INCREMENT' => true],
            'name' => ['constraint' => 256, 'type' => 'varchar'],
                ], ['id'], true, false, false);
        \DBUtil::add_foreign_key('acl_users', ['key' => 'group_id', 'reference' => ['table' => $this->table, 'column' => 'id']]);
        \DB::insert()
                ->table($this->table)
                ->columns(['name'])
                ->values([['مدیر سیستم']])
                ->execute();
        // create admin user
        \DB::insert()
                ->table('acl_users')
                ->columns(['username', 'email', 'password', 'group_id', 'is_active', 'is_confirm', 'unsuccess', 'remember', 'is_locked', 'lock_at'])
                ->values([['admin', 'atabak.h@gmail.com', \Acl\Acl::password_hash('Data@123'), 1, true, true, 0, '', false, 0]])
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
