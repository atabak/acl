<?php

\Autoloader::add_core_namespace('Acl');

\Autoloader::add_classes(
        array(
            /**
             * classes
             */
            'Acl\\Acl'                      => __DIR__.'/classes/acl/acl.php',
            'Acl\\Access'                   => __DIR__.'/classes/acl/access.php',
            'Acl\\Driver'                   => __DIR__.'/classes/acl/driver.php',
            'Acl\\Login'                    => __DIR__.'/classes/acl/login.php',
            'Acl\\Logout'                   => __DIR__.'/classes/acl/logout.php',
            'Acl\\Forget'                   => __DIR__.'/classes/acl/forget.php',
            'Acl\\Fields'                   => __DIR__.'/classes/acl/fields.php',
            'Acl\\Menu'                     => __DIR__.'/classes/acl/menu.php',
            /**
             * models
             */
            'Acl\\Model_User'               => __DIR__.'/classes/model/user.php',
            'Acl\\Model_Userpermission'     => __DIR__.'/classes/model/userpermission.php',
            'Acl\\Model_Profile'            => __DIR__.'/classes/model/profile.php',
            'Acl\\Model_Group'              => __DIR__.'/classes/model/group.php',
            'Acl\\Model_Group_Field'        => __DIR__.'/classes/model/group/field.php',
            'Acl\\Model_Group_Field_Type'   => __DIR__.'/classes/model/group/type.php',
            'Acl\\Model_Group_Field_Values' => __DIR__.'/classes/model/group/values.php',
            'Acl\\Model_Groupaccess'        => __DIR__.'/classes/model/access/groupaccess.php',
            'Acl\\Model_Module'             => __DIR__.'/classes/model/access/module.php',
            'Acl\\Model_Controller'         => __DIR__.'/classes/model/access/controller.php',
            'Acl\\Model_Actions'            => __DIR__.'/classes/model/access/actions.php',
            'Acl\\Model_Access_Module'      => __DIR__.'/classes/model/access/access_module.php',
            'Acl\\Model_Access_Controller'  => __DIR__.'/classes/model/access/access_controller.php',
            'Acl\\Model_Access_Action'      => __DIR__.'/classes/model/access/access_action.php',
        // profile model relation
        //'Acl\\Model_Profile_modelName'         => __DIR__.'/classes/model/profile/model_name.php',
        )
);
