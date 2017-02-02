<?php

namespace Acl;

class Access
{

    public static function del_access($user_id)
    {
        $module     = Model_Access_Module::query()
                ->where('user_id', $user_id)
                ->delete();
        $controller = Model_Access_Controller::query()
                ->where('user_id', $user_id)
                ->delete();
        $action     = Model_Access_Action::query()
                ->where('user_id', $user_id)
                ->delete();
    }

    // set user access[new]
    public static function new_access($user_id, $modules, $controllers, $actions)
    {
        // delete current user modules
        Model_Access_Module::query()->where('user_id', $user_id)->delete();
        // delete current user controllers
        Model_Access_Controller::query()->where('user_id', $user_id)->delete();
        // delete current user actions
        Model_Access_Action::query()->where('user_id', $user_id)->delete();
        $new_modules = \DB::insert()->table(Model_Access_Module::table())->columns(['user_id', 'module_id']);
        foreach ($modules as $module)
        {
            $new_modules->values([$user_id, $module]);
        }
        $new_modules->execute();
        $new_controllers = \DB::insert()->table(Model_Access_Controller::table())->columns(['user_id', 'controller_id']);
        foreach ($controllers as $controller)
        {
            $new_controllers->values([$user_id, $controller]);
        }
        $new_controllers->execute();
        $new_actions = \DB::insert()->table(Model_Access_Action::table())->columns(['user_id', 'action_id']);
        foreach ($actions as $action)
        {
            $new_actions->values([$user_id, $action]);
        }
        $new_actions->execute();
        return true;
    }

    // set user access in databse
    public static function set_access($user_id, array $access, $cache = true)
    {
        $entry             = Model_Access::forge();
        $entry->user_id    = $user_id;
        $entry->access     = serialize($access);
        $entry->created_by = Acl::current_user_id();
        $entry->create_at  = \Myclasses\FNC::currentdbtime();
        if ($entry->save())
        {
            if ($cache)
            {
                self::cache_access_create($user_id, $access);
            }
            return true;
        }
        return false;
    }

    // update user access in databse
    public static function update_access($user_id, array $access, $cache = true)
    {
        $entry = Model_Access::find_by_usser_id($user_id);
        if ($entry)
        {
            $entry->access     = serialize($access);
            $entry->updated_by = Acl::current_user_id();
            $entry->updated_at = \Myclasses\FNC::currentdbtime();
            if ($entry->save())
            {
                if ($cache)
                {
                    self::cache_access_create($user_id, $access);
                }
                return true;
            }
            return false;
        }
        else
        {
            return self::set_access($user_id, $access);
        }
    }

    // get user access array
    public static function get_access($user_id)
    {
        $cache = self::cache_access_get($user_id);
        if ($cache)
        {
            return $cache;
        }
        $entry = Model_Access::find_by_usser_id($user_id);
        return unserialize($entry);
    }

    // create cache cache file
    public static function cache_access_create($user_id, $access)
    {
        self::cache_access_delete($user_id);
        \Cache::set('acl.'.$user_id, $access, \Config::get('access.cache_time'));
    }

    // delete user cache file
    public static function cache_access_delete($user_id)
    {
        \Cache::delete('acl.'.$user_id);
    }

    // get user cache access in array
    public static function cache_access_get($user_id)
    {
        try
        {
            $content = \Cache::get('acl.'.$user_id);
            if ($content)
            {
                return ($content);
            }
        }
        catch (Exception $ex)
        {
            return false;
        }
    }

    // check user access
    public static function is_access($user_id, $module, $controller, $action)
    {
        $access = self::get_access($user_id);
        if ($access)
        {
            foreach ($access as $m_name => $m_values)
            {
                if ($m_name == $module)
                {
                    foreach ($m_values as $c_name => $c_values)
                    {
                        if ($c_name == $controller)
                        {
                            foreach ($c_values as $a_name => $a_values)
                            {
                                if ($a_name == $action)
                                {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    // create user access menu
    public static function access_menu($user_id, array $select)
    {
        $access = self::get_access($user_id);
        $menu   = '';
        if ($access)
        {
            foreach ($access as $m_name => $m_value)
            {
                if ($select[0] == $m_name)
                {
                    $m_active = ' menu-open';
                    $tmm      = ' active';
                }
                $menu .= '<li class="treeview'.$tmm.'">';
                $menu .= '  <a href="#"><i class="fa fa-share"></i><span>'.$m_name.'</span><i class="fa fa-angle-right pull-left"></i></a>';
                $menu .= '      <ul class="treeview-menu'.$m_active.'">';
                foreach ($m_value as $c_name => $c_value)
                {
                    if ($select[0] == $m_name && $select[1] == $c_name)
                    {
                        $c_active = ' active';
                    }
                    $menu .= '      <li>';
                    $menu .= '          <ul class="treeview-menu">';
                    foreach ($c_value as $a_name => $a_value)
                    {
                        if ($a_value)
                        {
                            $menu .= '<li><a href="#"><i class="fa fa-circle-o"></i>'.$a_name.'</a></li>';
                        }
                    }
                    $menu .= '          </ul>';
                    $menu .= '      </li>';
                }
                $menu .= '      </ul>';
                $menu .= '</li>';
            }
        }
        return $menu;
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
