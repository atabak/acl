<?php

namespace Acl;

class Model_User extends \Orm\Model
{

    protected static $_table_name = 'acl_users';
    protected static $_properties = array(
        'id',
        'username',
        'email',
        'password',
        'remember',
        'group_id',
        'is_locked',
        'is_active',
        'is_confirm',
        'unsuccess'
    );
    protected static $_belongs_to = array(
        'group' => array(
            'key_from'       => 'group_id',
            'model_to'       => 'Model_Group',
            'key_to'         => 'id',
            'cascade_save'   => true,
            'cascade_delete' => false
        )
    );
    protected static $_has_one    = array(
        'profile' => array(
            'key_from'       => 'id',
            'model_to'       => 'Model_Profile',
            'key_to'         => 'user_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ),
    );
    protected static $_has_many   = array(
        'values' => array(
            'key_from'       => 'id',
            'model_to'       => 'Model_Group_Field_Values',
            'key_to'         => 'user_id',
            'cascade_save'   => true,
            'cascade_delete' => false
        ),
    );
    protected static $_observers  = array(
        'Orm\\Observer_Self' => array('events' => array('before_insert', 'before_update')),
    );

    public function _event_before_insert()
    {
        $this->password = Acl::password_hash($this->password);
        $this->username = \Str::lower($this->username);
    }

    public function _event_before_update()
    {
        if ($this->password && !empty($this->password))
        {
            //$this->password = Acl::password_hash($this->password);
        }
        $this->username = \Str::lower($this->username);
    }

    /**
     * check user name or email for login
     * @param type $username_or_email
     * @return array
     */
    public static function authenticate($username_or_email)
    {
        // check for not empty username or email
        if (!empty($username_or_email))
        {

            // lowec case username or email address
            $username_or_email = \Str::lower($username_or_email);

            // search for user
            $user = static::query()
                    ->where('username', $username_or_email)
                    ->or_where('email', $username_or_email)
                    ->get_one();

            // find user
            if ($user)
            {
                // banned user
                if (!$user->is_unlock())
                {
                    return array('locked', false);
                }
                // user not active yet
                if ($user->is_unactive())
                {
                    return array('not_active', false);
                }
                // user not confirm yet
                if ($user->is_unconfirm())
                {
                    return array('not_confirm', false);
                }
                // user connfirm, active, not banned
                // so send user object
                return array($user, true);
            }
            else
            {
                // user not find
                return array('username', false);
            }
        }
        return array('empty', false);
    }

    /**
     * check user name or email for login
     * @param type $username_or_email
     * @return array
     */
    public static function authenticatebyremember($remember_key)
    {
        // check for not empty userremember key
        if (!empty($remember_key))
        {


            // search for user by remember key
            $user = static::query()
                    ->where('remember', $remember_key)
                    ->get_one();

            // find user
            if ($user)
            {
                // banned user
                if (!$user->is_unlock())
                {
                    return array('locked', false);
                }
                // user not active yet
                if ($user->is_unactive())
                {
                    return array('not_active', false);
                }
                // user not confirm yet
                if ($user->is_unconfirm())
                {
                    return array('not_confirm', false);
                }
                // user connfirm, active, not banned
                // so send user object
                return array($user, true);
            }
            else
            {
                // user not find
                return array('username', false);
            }
        }
        return array('empty', false);
    }

    /**
     * check if current user is lock
     * @return boolean
     */
    public function is_lock()
    {
        return $this->is_locked ? true : false;
    }

    /**
     * check if current user is unlock
     * @return boolean
     */
    public function is_unlock()
    {
        return $this->is_locked ? false : true;
    }

    /**
     * unlock current user
     */
    public function unlock_user()
    {
        $this->is_locked = false;
        $this->save();
    }

    /**
     * lock current user
     */
    public function lock_user()
    {
        $this->is_locked = true;
        $this->save();
    }

    /**
     * check active for current user
     * @return boolean
     */
    public function is_unactive()
    {
        return $this->is_active ? false : true;
    }

    /**
     * active current user
     */
    public function active_user()
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     * unactive current user
     */
    public function unactive_user()
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * check current user for confirm
     * @return boolean
     */
    public function is_unconfirm()
    {
        return $this->is_confirm ? false : true;
    }

    /**
     * confirm current user
     */
    public function confirm_user()
    {
        $this->is_comfirm = true;
        $this->save();
    }

    /**
     * unconfirm current user
     */
    public function unconfirm_user()
    {
        $this->is_comfirm = false;
        $this->save();
    }

    /**
     * update current user attempts wrong login
     * if unsuccess more then 12 then user block
     */
    public function update_attempts()
    {
        $this->unsuccess += 1;
        if ($this->unsuccess > 12)
        {
            $this->lock_user();
        }
    }

    /**
     * run after login user for reset unsuccess and unlock user
     */
    public function after_login()
    {
        $this->unsuccess = 0;
        $this->is_locked = false;
        $this->save();
    }

    /**
     * check for user duplicate
     * @param type $username
     * @param type $email
     * @param type $id
     * @return boolean
     */
    public static function is_duplicate($username, $email, $id = NULL)
    {
        // check for nit empty username or email
        if (!empty($username) && !empty($email))
        {
            $duplicate = static::query()
                    ->select('id')
                    ->and_where_open()
                    ->or_where('username', \Str::lower($username))
                    ->or_where('email', $email)
                    ->and_where_close();
            // check duplicate for update user
            if ($id)
            {
                $duplicate->where('id', '!=', $id);
            }
            return $duplicate->count() ? true : false;
        }
        else
        {
            return false;
        }
    }

}
