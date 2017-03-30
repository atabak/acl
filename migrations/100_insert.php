<?php

namespace Fuel\Migrations;

class insert
{

    public function up()
    {
        \DB::insert()
                ->table('acl_users_groups')
                ->columns(['name'])
                ->values([['مدیر سیستم']])
                ->execute();
        \DB::insert()
                ->table('acl_users')
                ->columns(['username', 'email', 'password', 'group_id', 'is_active', 'is_confirm', 'unsuccess', 'remember', 'is_locked', 'lock_at'])
                ->values([['admin', 'atabak.h@gmail.com', \Acl\Acl::password_hash('Data@123'), 1, true, true, 0, '', false, 0]])
                ->execute();

        \DB::insert()
                ->table('acl_users_groups_fields_type')
                ->columns(['name'])
                ->values([
                        ['کاراکتر'],
                        ['تاریخ شمسی'],
                        ['تاریخ میلادی'],
                        ['فایل'],
                        ['لیست انتخابی'],
                        ['متن'],
                        ['جدول']
                ])
                ->execute();

        \DB::insert()
                ->table('acl_users_modules')
                ->columns(['name', 'url', 'order', 'icon', 'color', 'is_active'])
                ->values([['مدیریت کاربران', 'dashboard/users', 1000, 'fa-user', '', 1]])
                ->execute();

        \DB::insert()
                ->table('acl_users_modules_controller')
                ->columns(['module_id', 'name', 'url', 'order', 'is_active'])
                ->values([
                        [1, 'کاربران', 'user', 1, 1],
                        [1, 'مدیریت گروه های کاربری', 'groups', 1, 1],
                        [1, 'مدیریت دسترسی ها', 'access', 1, 1],
                        ]
                )
                ->execute();

        \DB::insert()
                ->table('acl_users_modules_controllers_actions')
                ->columns(['controller_id', 'name', 'uri', 'order', 'is_active', 'is_visible'])
                ->values([
                        [1, 'مدیریت', 'index', 1, 1, 0],
                        [1, 'ایجاد کاربر', 'create', 1, 1, 1],
                        [1, 'ویرایش کاربر', 'edit', 3, 1, 0],
                        [1, 'تایید کاربران', 'confirmusr', 3, 1, 0],
                        [1, 'جستجو', 'search', 1, 1, 1],
                        [2, 'مدیریت گروه ها', 'index', 1, 1, 1],
                        [2, 'مدیریت فیلد ها', 'fields', 2, 1, 1],
                        [3, 'ماژول', 'modules', 1, 1, 1],
                        [3, 'کلاس ها', 'controller', 2, 1, 1],
                        [3, 'توابع', 'actions', 3, 1, 1],
                        ]
                )
                ->execute();

        \DB::insert()
                ->table('acl_users_access_actions')
                ->columns(['user_id', 'action_id'])
                ->values([
                        [1, 1],
                        [1, 2],
                        [1, 3],
                        [1, 4],
                        [1, 5],
                        [1, 6],
                        [1, 7],
                        [1, 8],
                        [1, 9],
                        [1, 10],
                        ]
                )
                ->execute();

        \DB::insert()
                ->table('acl_users_access_controller')
                ->columns(['user_id', 'controller_id'])
                ->values([
                        [1, 1],
                        [1, 2],
                        [1, 3],
                        ]
                )
                ->execute();

        \DB::insert()
                ->table('acl_users_access_module')
                ->columns(['user_id', 'module_id'])
                ->values([[1, 1]])
                ->execute();

        \DB::insert()
                ->table('acl_users_profiles')
                ->columns(['user_id', 'first', 'last', 'cell', 'pic', 'created_at', 'created_by', 'confirm_at', 'confirm_by'])
                ->values([[1, 'اتابک', 'حسین نیا', '09354303475', '', \Myclasses\FNC::currentdbtime(), 1, \Myclasses\FNC::currentdbtime(), 1]])
                ->execute();
    }

    public function down()
    {
        
    }

}
