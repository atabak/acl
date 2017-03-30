<?php

namespace Fuel\Migrations;

class indexes
{

    public function up()
    {
        \DBUtil::create_index('acl_users', 'username', 'acl_users_username', 'UNIQUE');
        \DBUtil::create_index('acl_users', 'email', 'acl_users_email', 'UNIQUE');
        \DBUtil::create_index('acl_users', 'group_id', 'acl_users_group_id');
        \DBUtil::create_index('acl_users_groups', 'created_by', 'acl_users_group_created_by');
        \DBUtil::create_index('acl_users_groups', 'updated_by', 'acl_users_group_updated_by');
        \DBUtil::create_index('acl_users_groups_fields', 'group_id', 'acl_users_groups_fields_group_id');
        \DBUtil::create_index('acl_users_groups_fields', 'type_id', 'acl_users_groups_fields_type_id');
        \DBUtil::create_index('acl_users_groups_fields', 'order', 'acl_users_groups_fields_order');
        \DBUtil::create_index('acl_users_groups_fields', 'created_by', 'acl_users_groups_fields_created_by');
        \DBUtil::create_index('acl_users_groups_fields', 'updated_by', 'acl_users_groups_fields_updated_by');
        \DBUtil::create_index('acl_users_groups_fields', 'default_values', 'field_default_values', 'FULLTEXT');
        \DBUtil::create_index('acl_users_groups_fields_values', 'user_id', 'acl_users_groups_fields_values_user_id');
        \DBUtil::create_index('acl_users_groups_fields_values', 'field_id', 'acl_users_groups_fields_values_field_id');
        \DBUtil::create_index('acl_users_groups_fields_values', 'created_by', 'acl_users_groups_fields_values_created_by');
        \DBUtil::create_index('acl_users_groups_fields_values', 'value', 'acl_users_groups_fields_values_value', 'FULLTEXT');
        \DBUtil::create_index('acl_users_modules', 'url', 'acl_users_modules_url');
        \DBUtil::create_index('acl_users_modules', 'order', 'acl_users_modules_order');
        \DBUtil::create_index('acl_users_modules', 'is_active', 'acl_users_modules_is_active');
        \DBUtil::create_index('acl_users_modules_controller', 'module_id', 'acl_users_modules_controller_module_id');
        \DBUtil::create_index('acl_users_modules_controller', 'url', 'acl_users_modules_controller_url');
        \DBUtil::create_index('acl_users_modules_controller', 'order', 'acl_users_modules_controller_order');
        \DBUtil::create_index('acl_users_modules_controller', 'is_active', 'acl_users_modules_controller_is_active');
        \DBUtil::create_index('acl_users_modules_controllers_actions', 'controller_id', 'acl_users_modules_controllers_actions_controller_id');
        \DBUtil::create_index('acl_users_modules_controllers_actions', 'order', 'acl_users_modules_controllers_actions_order');
        \DBUtil::create_index('acl_users_modules_controllers_actions', 'is_active', 'acl_users_modules_controllers_actions_is_active');
        \DBUtil::create_index('acl_users_modules_controllers_actions', 'uri', 'acl_users_modules_controllers_actions_uri');
        \DBUtil::create_index('acl_users_access_actions', 'action_id', 'acl_users_access_actions_action_id');
        \DBUtil::create_index('acl_users_access_actions', 'user_id', 'acl_users_access_actions_user_id');
        \DBUtil::create_index('acl_users_access_controller', 'controller_id', 'acl_users_access_controller_controller_id');
        \DBUtil::create_index('acl_users_access_controller', 'user_id', 'acl_users_access_controller_user_id');
        \DBUtil::create_index('acl_users_access_module', 'module_id', 'acl_users_access_module_module_id');
        \DBUtil::create_index('acl_users_access_module', 'user_id', 'acl_users_access_module_user_id');
        \DBUtil::create_index('acl_users_profiles', 'user_id', 'acl_users_profiles_user_id');
        \DBUtil::create_index('acl_users_profiles', 'created_by', 'acl_users_profiles_created_by');
        \DBUtil::create_index('acl_users_profiles', 'updated_by', 'acl_users_profiles_updated_by');
        \DBUtil::create_index('acl_users_profiles', 'confirm_by', 'acl_users_profiles_confirm_by');
        \DBUtil::create_index('acl_users_profiles', 'unlocked_by', 'acl_users_profiles_unlocked_by');
    }

    public function down()
    {
        
    }

}
