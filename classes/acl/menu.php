<?php

namespace Acl;

class Menu
{

    public static function getModules($current_user)
    {
        try
        {
            $modules = \Cache::get('menu.'.$current_user.'.module');
        }
        catch (\CacheNotFoundException $e)
        {
            $moduelAccessSubQuery = Model_Access_Module::query()
                    ->select('module_id')
                    ->where('user_id', $current_user);

            $modules = Model_Module::query()
                    ->where('id', 'in', $moduelAccessSubQuery->get_query(false))
                    ->order_by('order')
                    ->get();
            \Cache::set('menu.'.$current_user.'.module', $modules);
        }
        return $modules;
    }

    public static function getControllers($current_user)
    {
        try
        {
            $controllers = \Cache::get('menu.'.$current_user.'.controller');
        }
        catch (\CacheNotFoundException $e)
        {
            $controllerAccessSubQuery = Model_Access_Controller::query()
                    ->select('controller_id')
                    ->where('user_id', $current_user);

            $controllers = Model_Controller::query()
                    ->where('id', 'in', $controllerAccessSubQuery->get_query(false))
                    ->order_by('order')
                    ->get();
            \Cache::set('menu.'.$current_user.'.controller', $controllers);
        }
        return $controllers;
    }

    public static function getActions($current_user)
    {
        try
        {
            $actions = \Cache::get('menu.'.$current_user.'.actions');
        }
        catch (\CacheNotFoundException $e)
        {
            $actionsAccessSubQuery = Model_Access_Action::query()
                    ->select('action_id')
                    ->where('user_id', $current_user);

            $actions = Model_Actions::query()
                    ->where('id', 'in', $actionsAccessSubQuery->get_query(false))
                    ->order_by('order')
                    ->get();
            \Cache::set('menu.'.$current_user.'.actions', $actions);
        }
        return $actions;
    }

    public static function MenuCreate($active_module = null, $active_controller = null, $active_action = null)
    {
        $menu = '';

        // define current user
        $current_user = Acl::current_user_id();

        // get user modules
        $modules = self::getModules($current_user);

        // get user controllers
        $controllers = self::getControllers($current_user);

        // get user actions
        $actions = self::getActions($current_user);

        // set menu side 
        $side = 'left';

        if ($modules)
        {
            foreach ($modules as $module)
            {
                $module_active = false;

                if ($module && (str_replace('dashboard/', '', $module['url']) == $active_module))
                {
                    $module_active = true;
                }

                $menu .= '<li class="'.($module_active ? 'active ' : '').'treeview">
                                    <a href="#">
                                        <i class="fa '.$module['icon'].'"></i> <span>'.$module['name'].'</span> <i class="fa fa-angle-'.$side.' pull-'.$side.'"></i>
                                    </a>
                                    <ul class="treeview-menu">';

                // begin module controller [level 2]
                if ($controllers)
                {
                    foreach ($controllers as $controller)
                    {
                        if ($controller->module_id == $module->id)
                        {
                            $controller_active = false;

                            if ($active_controller && $controller['url'] == $active_controller && $module_active)
                            {
                                $controller_active = true;
                            }

                            $controller_address = \Uri::create($module['url'].'/'.$controller['url']);

                            $menu .= '  <li class="'.($controller_active ? 'active' : '').'">
                                            <a href="'.$controller_address.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;'.$controller['name'].' <i class="fa fa-angle-'.$side.' pull-'.$side.'"></i></a>
                                            <ul class="treeview-menu">';
                            
                            if ($actions)
                            {
                                foreach ($actions as $action)
                                {
                                    if ($action->controller_id == $controller->id)
                                    {
                                        $action_active = false;

                                        if ($action['is_visible'])
                                        {
                                            if (!strpos($action['uri'], '/') === false)
                                            {
                                                $address = explode('/', $action['uri']);

                                                if ($active_action == str_replace('.html', '', $address[count($address) - 1]) && $controller_active)
                                                {
                                                    $action_active = true;
                                                }

                                                $menu .= '  <li class="'.($action_active ? 'active' : '').'"><a href="'.\Uri::create($action['uri']).'" class="mtpa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;<span class="mtp">'.$action['name'].'</span></a></li>';
                                            }
                                            else
                                            {
                                                if ($active_action == str_replace('.html', '', $action['uri']) && $controller_active)
                                                {
                                                    $action_active = true;
                                                }

                                                $menu .= '  <li class="'.($action_active ? 'active' : '').'"><a href="'.\Uri::create($module['url'].'/'.$controller['url'].'/'.$action['uri']).'" class="mtpa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;<span class="mtp">'.$action['name'].'</span></a></li>';
                                            }
                                        }
                                    }
                                }
                            }
                            // close controller menu [level 2]
                            $menu .= '          </ul>
                                        </li>';
                        }
                    }
                }

                // close module menu
                $menu .= '          </ul>
                        </li>';
            }
        }
        return $menu;
    }

}
