<?php

namespace Acl;

class Menu
{

    public static function create_menu($active_module = null, $active_controller = null, $active_action = null)
    {
        $menu         = '';
        $current_user = Acl::current_user_id();
        $modules      = \DB::select(array('m.id', 'id'), array('m.url', 'url'), array('m.name', 'name'), array('m.icon', 'icon'))
                ->from(array(Model_Module::table(), 'm'))
                ->join(array(Model_Access_Module::table(), 'a'), 'inner')
                ->on('m.id', '=', 'a.module_id')
                ->where('a.user_id', $current_user)
                ->cached(2592000, 'menu.module_'.$current_user)
                ->order_by('m.order', 'ASC')
                ->execute();
        $side         = 'left';
        if ($modules)
        {
            foreach ($modules as $module)
            {
                var_dump($module);
                $module_active = false;
                if ($module && (str_replace('dashboard/', '', $module['url']) == $active_module))
                {
                    $module_active = true;
                }
                $menu        .= '<li class="'.($module_active ? 'active ' : '').'treeview">
                            <a href="#">
                                <i class="fa '.$module['icon'].'"></i> <span>'.$module['name'].'</span> <i class="fa fa-angle-'.$side.' pull-'.$side.'"></i>
                            </a>
                            <ul class="treeview-menu">';
                $controllers = \DB::select(array('c.id', 'id'), array('c.url', 'url'), array('c.name', 'name'))
                        ->from(array(Model_Controller::table(), 'c'))
                        ->join(array(Model_Access_Controller::table(), 'a'), 'inner')
                        ->on('a.controller_id', '=', 'c.id')
                        ->where('a.user_id', '=', $current_user)
                        ->order_by('c.order', 'asc')
                        ->cached(2592000, 'menu.controller_'.$current_user)
                        ->execute();
                if ($controllers)
                {
                    foreach ($controllers as $controller)
                    {
                        $controller_active = false;
                        if ($active_controller && $controller['url'] == $active_controller && $module_active)
                        {
                            $controller_active = true;
                        }
                        $controller_address = \Uri::create($module['url'].'/'.$controller['url']);
                        $menu               .= '<li class="'.($controller_active ? 'active' : '').'">
                                        <a href="'.$controller_address.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;'.$controller['name'].' <i class="fa fa-angle-'.$side.' pull-'.$side.'"></i></a>
                                        <ul class="treeview-menu">';
                        $actions            = \DB::select(array('a.name', 'name'), array('a.uri', 'uri'), array('a.is_visible', 'is_visible'))
                                ->from(array(Model_Actions::table(), 'a'))
                                ->join(array(Model_Access_Action::table(), 's'), 'inner')
                                ->on('s.action_id', '=', 'a.id')
                                ->where('a.controller_id', $controller['id'])
                                ->where('s.user_id', $current_user)
                                ->cached(2592000, 'menu.action_'.$current_user)
                                ->order_by('a.order', 'asc')
                                ->execute();
                        if ($actions)
                        {
                            foreach ($actions as $action)
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
                        $menu .= '      </ul>
                                    </li>';
                    }
                }
                $menu .= '  </ul>
                        </li>';
            }
        }
        return $menu;
    }

}
