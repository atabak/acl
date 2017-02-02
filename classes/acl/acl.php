<?php

namespace Acl;

class Acl
{

    public $driver;

    public static function forge($config = array())
    {
        static $instance = null;
        if ($instance === null) {
            $config           = array_merge(\Config::get('acl', array()), $config);
            $instance         = new static;
            $instance->driver = new Driver($config);
        }
        return $instance;
    }

    public static function is_login()
    {
        return static::driver()->is_login();
    }

    public static function set_user(Model_User $user)
    {
        static::driver()->set_user($user);
    }

    public static function current_user()
    {
        return static::driver()->current_user();
    }

    public static function current_user_id()
    {
        return static::driver()->current_user_id();
    }

    public static function login($username_or_email, $password, $remember = false)
    {
        if (empty($username_or_email) || empty($password)) {
            return false;
        }
        return static::driver()->authenticate_user($username_or_email, $password, $remember);
    }

    public static function auto_login($role = null)
    {
        return static::driver()->auto_login($role);
    }

    public static function logout($destroy = false)
    {
        return static::driver()->logout($destroy);
    }

    protected static function driver()
    {
        return static::forge()->driver;
    }

    public static function generate_token()
    {
        $token = join(':', array(\Str::random('alnum', 15), time()));
        return str_replace(array('+', '/', '=', 'l', 'I', 'O', '0'), array('p', 'q', 'r', 's', 'x', 'y', 'z'), base64_encode($token));
    }

    public static function password_hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
    }

    public static function password_check($password, $encrypted_password)
    {
        return password_verify($password, $encrypted_password);
    }

    public static function is_access($module, $controlle, $action)
    {
        return static::driver()->is_access($module, $controlle, $action);
    }

    public static function set_access($user_id, $modules, $controllers, $actions)
    {
        return static::driver()->set_access($user_id, $modules, $controllers, $actions);
    }

    public static function get_user_field($user = true, $field)
    {
        return static::driver()->get_user_field($user, $field);
    }

}
