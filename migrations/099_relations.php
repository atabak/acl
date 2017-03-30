<?php

namespace Fuel\Migrations;

class relations
{

    public function up()
    {
        \DBUtil::add_foreign_key('acl_users', ['key' => 'group_id', 'reference' => ['table' => 'acl_users_groups', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups', ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups', ['key' => 'updated_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups_fields', ['key' => 'group_id', 'reference' => ['table' => 'acl_users_groups', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups_fields', ['key' => 'type_id', 'reference' => ['table' => 'acl_users_groups_fields_type', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups_fields', ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups_fields', ['key' => 'updated_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_groups_fields_values', ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_groups_fields_values', ['key' => 'field_id', 'reference' => ['table' => 'acl_users_groups_fields', 'column' => 'id'], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_groups_fields_values', ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_modules_controller', ['key' => 'module_id', 'reference' => ['table' => 'acl_users_modules', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_modules_controllers_actions', ['key' => 'controller_id', 'reference' => ['table' => 'acl_users_modules_controller', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_actions', ['key' => 'action_id', 'reference' => ['table' => 'acl_users_modules_controllers_actions', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_actions', ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_controller', ['key' => 'controller_id', 'reference' => ['table' => 'acl_users_modules_controller', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_controller', ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_module', ['key' => 'module_id', 'reference' => ['table' => 'acl_users_modules', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_access_module', ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_profiles', ['key' => 'user_id', 'reference' => ['table' => 'acl_users', 'column' => 'id',], 'on_delete' => 'CASCADE']);
        \DBUtil::add_foreign_key('acl_users_profiles', ['key' => 'created_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_profiles', ['key' => 'updated_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_profiles', ['key' => 'confirm_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
        \DBUtil::add_foreign_key('acl_users_profiles', ['key' => 'unlocked_by', 'reference' => ['table' => 'acl_users', 'column' => 'id']]);
    }

    public function down()
    {
        
    }

}
