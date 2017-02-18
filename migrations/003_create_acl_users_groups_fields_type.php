<?php

namespace Fuel\Migrations;

class Create_acl_users_groups_fields_type
{

    protected $table = 'acl_users_groups_fields_type';

    public function up()
    {
        \DBUtil::create_table($this->table, array(
            'id'   => array('type' => 'int', 'AUTO_INCREMENT' => true),
            'name' => array('constraint' => 256, 'type' => 'varchar'),
                ), array('id'), true, false, false);
        // add default type
        \DB::insert()
                ->table($this->table)
                ->columns(array('name'))
                ->values(array(array('کاراکتر'), array('تاریخ شمسی'), array('تاریخ میلادی'), array('فایل'), array('لیست انتخابی'), array('متن')))
                ->execute();
    }

    public function down()
    {
        \DBUtil::drop_table($this->table);
    }

}
