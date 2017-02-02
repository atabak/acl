<?php

namespace Acl;

class Driver
{

    protected $config;
    protected $user;
    protected $session;

    public function __construct(array $config = null)
    {
        $this->config  = $config;
        $this->session = \Session::instance();
        //$this->is_login();
    }

    /**
     * check for user login or not by check session
     * @return boolean
     */
    public function is_login()
    {
        $user_id = $this->session->get('acl.user.id');
        if (empty($user_id))
        {
            return false;
        }
        else
        {
            if (isset($this->user) && $this->user->id == $user_id)
            {
                return true;
            }
            else
            {
                $this->user = null;
                $user       = Model_User::find($user_id);
                $this->set_user($user);
                return true;
            }
        }
    }

    /**
     * login user by username or email address and password
     * and save remember key
     * @param type $username_or_email
     * @param type $password
     * @param type $remember
     * @return string
     */
    public function authenticate_user($username_or_email, $password, $remember)
    {
        $user = Model_User::authenticate($username_or_email);
        if ($user[1])
        {
            $user = $user[0];
            if (password_verify($password, $user->password))
            {
                if ($remember === true)
                {
                    $user->remember = self::generate_token();
                    \Cookie::set($this->config['rememberable']['key'], $user->remember_token, $this->config['rememberable']['ttl'], null, null, null, true);
                }
                if ($this->complete_login($user))
                {
                    return 'ok';
                }
                return 'no';
            }
            else
            {
                $user->update_attempts();
                return 'password';
            }
        }
        return $user[0];
    }

    /**
     * login user with remember key
     * @param type $role
     * @return boolean
     */
    public function auto_login()
    {
        if (($token = \Cookie::get($this->config['rememberable']['key'])))
        {
            $user = \Model_User::authenticatebyremember($token);
            if ($user)
            {
                $this->complete_login($user);
                return true;
            }
        }
        return false;
    }

    /**
     * set user to session
     * @param \Acl\Model_User $user
     * @return boolean
     */
    public function complete_login(Model_User $user)
    {
        // remove user attampt
        $user->after_login();
        // set user login
        $this->set_user($user);
        return true;
    }

    /**
     * set user id to session
     * @param \Acl\Model_User $user
     */
    public function set_user(Model_User $user)
    {
        $this->session->set('acl.user.id', $user->id);
        //$this->session->rotate();
        $this->user = $user;
    }

    /**
     * return current user model
     * @return boolean or model user
     */
    public function current_user()
    {
        if (isset($this->user))
        {
            return $this->user;
        }
        else
        {
            if ($this->is_login())
            {
                return $this->user;
            }
            else
            {
                return false;
            }
        }
    }

    /**
     * return current user id
     * @return boolean or user id
     */
    public function current_user_id()
    {
        if ($this->current_user())
        {
            return $this->user->id;
        }
        return false;
    }

    /**
     * logout user
     * @param type $destroy
     * @return boolean
     */
    public function logout($destroy)
    {
        // run after logout function
        $this->user = null;
        $this->session->delete('acl.user.id');
        if ($destroy === true)
        {
            $this->session->destroy();
            $cookie_key = $this->config['rememberable']['key'];
            if (\Cookie::get($cookie_key))
            {
                \Cookie::delete($cookie_key);
            }
        }
        else
        {
            $this->session->rotate();
        }
        return !$this->is_login();
    }

    /**
     * generate remember mr tocken
     * @return string
     */
    public static function generate_token()
    {
        $token = join(':', array(\Str::random('alnum', 15), time()));
        return str_replace(array('+', '/', '=', 'l', 'I', 'O', '0'), array('p', 'q', 'r', 's', 'x', 'y', 'z'), base64_encode($token));
    }

    /**
     * check user access to module->controller->action
     * @param type $module
     * @param type $controller
     * @param type $action
     * @return boolean
     */
    public function is_access($module, $controller, $action)
    {
        $access_user = Model_Module::query()
                // related by controller, action, access[module,controller,action]
                ->related('controlles')
                ->related('controlles.actions')
                ->related('access')
                ->related('controlles.access')
                ->related('controlles.actions.access')
                // search user id in access models
                ->where('access.user_id', $this->current_user_id())
                ->where('controlles.access.user_id', $this->current_user_id())
                ->where('controlles.actions.access.user_id', $this->current_user_id())
                // search address
                ->and_where_open()
                ->or_where('url', 'dashboard/'.$module)
                ->or_where('url', $module)
                ->and_where_close()
                ->where('controlles.url', $controller)
                ->and_where_open()
                ->or_where('controlles.actions.uri', $action)
                ->or_where('controlles.actions.uri', $action.'.html')
                ->and_where_close()
                // count access
                ->count();
        return $access_user ? true : false;
    }

    /**
     * set new access to user
     * @param type $user_id
     * @param type $modules
     * @param type $controllers
     * @param type $actions
     * @return boolean
     */
    public function set_access($user_id, $modules, $controllers, $actions)
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

}
