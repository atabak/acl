<?php

namespace Acl;

class Menu
{

    public static function create_menu($active_module = null, $active_controller = null, $active_action = null)
    {
        $menu         = '';
        $current_user = Acl::current_user_id();
        $modules      = Model_Access_Module::query()
                ->related('module')
                ->where('user_id', $current_user)
                ->order_by('module.order')
                ->get();
        if ($modules) {
            foreach ($modules as $module) {
                $module_active = false;
                if ($module && (str_replace('dashboard/', '', $module['module']['url']) == $active_module)) {
                    $module_active = true;
                }
                $menu .= '<li class="'.($module_active ? 'active ' : '').'treeview">
                            <a href="#">
                                <i class="fa '.$module['module']['icon'].'"></i> <span>'.$module['module']['name'].'</span> <i class="fa fa-angle-left pull-left"></i>
                            </a>
                            <ul class="treeview-menu">';
                $controllers = Model_Access_Controller::query()
                        ->related('controller')
                        ->where('user_id', $current_user)
                        ->where('controller.module_id', $module['module']['id'])
                        ->order_by('controller.order')
                        ->get();
                if ($controllers) {
                    foreach ($controllers as $controller) {
                        $controller_active = false;
                        if ($active_controller && $controller['controller']['url'] == $active_controller && $module_active) {
                            $controller_active = true;
                        }
                        $controller_address = \Uri::create($module['module']['url'].'/'.$controller['controller']['url']);
                        $menu .= '<li class="'.($controller_active ? 'active' : '').'">
                                        <a href="'.$controller_address.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;'.$controller['controller']['name'].' <i class="fa fa-angle-left pull-left"></i></a>
                                        <ul class="treeview-menu">';
                        $actions            = Model_Access_Action::query()
                                ->related('action')
                                ->where('user_id', $current_user)
                                ->where('action.controller_id', $controller['controller']['id'])
                                ->order_by('action.order')
                                ->get();
                        if ($actions) {
                            foreach ($actions as $action) {
                                $action_active = false;
                                if ($action['action']->is_visible) {
                                    if (!strpos($action['action']->uri, '/') === false) {
                                        $address = explode('/', $action['action']->uri);
                                        if ($active_action == str_replace('.html', '', $address[count($address) - 1]) && $controller_active) {
                                            $action_active = true;
                                        }
                                        $menu .= '  <li class="'.($action_active ? 'active' : '').'"><a href="'.\Uri::create($action['action']->uri).'" class="mtpa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;<span class="mtp">'.$action['action']->name.'</span></a></li>';
                                    } else {
                                        if ($active_action == str_replace('.html', '', $action['action']->uri) && $controller_active) {
                                            $action_active = true;
                                        }
                                        $menu .= '  <li class="'.($action_active ? 'active' : '').'"><a href="'.\Uri::create($module['module']->url.'/'.$controller['controller']->url.'/'.$action['action']->uri).'" class="mtpa">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldsh;<span class="mtp">'.$action['action']->name.'</span></a></li>';
                                    }
                                }
                            }
                        }
                        // controller close
                        $menu .= '      </ul>
                                    </li>';
                    }
                }
                // module close
                $menu .= '  </ul>
                        </li>';
            }
        }
        return $menu;
    }

}
