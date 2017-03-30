<?php

namespace Acl;

class Access
{

    // delete all user access and cache
    public static function del_access($user_id)
    {
        Model_Access_Module::query()
                ->where('user_id', $user_id)
                ->delete();
        Model_Access_Controller::query()
                ->where('user_id', $user_id)
                ->delete();
        Model_Access_Action::query()
                ->where('user_id', $user_id)
                ->delete();
        // delete cache
        \Cache::delete_all('menu.'.$user_id);
        return true;
    }

    // set user access
    public static function new_access($user_id, $modules, $controllers, $actions)
    {
        self::del_access($user_id);

        $new_modules = \DB::insert()
                ->table(Model_Access_Module::table())
                ->columns(['user_id', 'module_id']);

        foreach ($modules as $module)
        {
            $new_modules->values([$user_id, $module]);
        }
        $new_modules->execute();


        $new_controllers = \DB::insert()
                ->table(Model_Access_Controller::table())
                ->columns(['user_id', 'controller_id']);

        foreach ($controllers as $controller)
        {
            $new_controllers->values([$user_id, $controller]);
        }

        $new_controllers->execute();

        $new_actions = \DB::insert()
                ->table(Model_Access_Action::table())
                ->columns(['user_id', 'action_id']);

        foreach ($actions as $action)
        {
            $new_actions->values([$user_id, $action]);
        }

        $new_actions->execute();

        return true;
    }

    // get actions array
    public static function getUserActions($user_id)
    {
        $access = self::cache_access_get($user_id);

        $return = [];

        if (count($access))
        {
            foreach ($access as $controller)
            {
                foreach ($controller as $actions)
                {
                    foreach ($actions as $action)
                    {
                        $return[] = $action;
                    }
                }
            }
        }

        return $return;
    }

}
