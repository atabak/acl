<?php

namespace Acl;

class Model_Profile extends \Orm\Model
{

    public static $_table_name = 'acl_users_profiles';

    /**
     * @property string $id
     * @property string $user_id
     * @property string $first
     * @property string $last
     * @property string $pic
     * @property string $cell
     * @property string $created_at
     * @property string $created_by
     * @property string $updated_at
     * @property string $updated_by
     * @property string $confirm_at
     * @property string $confirm_by
     * @property string $locked_at
     * @property string $unlocked_at
     * @property string $unlocked_by
     * @property string $creator
     * @property string $editor
     * @property string $confirm
     * @property string $unlock
     */
    protected static $_properties = [
        'id',
        'user_id',
        'first',
        'last',
        'pic',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'confirm_at',
        'confirm_by',
        'locked_at',
        'unlocked_at',
        'unlocked_by',
    ];
    protected static $_belongs_to = [
        'creator' => ['key_from' => 'created_by', 'model_to' => '\\Acl\\Model_User', 'key_to' => 'id'],
        'editor'  => ['key_from' => 'updated_by', 'model_to' => '\\Acl\\Model_User', 'key_to' => 'id'],
        'confirm' => ['key_from' => 'confirm_by', 'model_to' => '\\Acl\\Model_User', 'key_to' => 'id'],
        'unlock'  => ['key_from' => 'unlocked_by', 'model_to' => '\\Acl\\Model_User', 'key_to' => 'id'],
    ];
    protected static $_observers  = [
        'Orm\\Observer_Self' => ['events' => ['before_insert', 'before_update']],
    ];

    public function _event_before_insert()
    {
        $this->user_id    = (int) $this->user_id;
        $this->created_at = \Myclasses\FNC::currentdbtime();
        $this->created_by = \Acl\Acl::current_user_id();
    }

    public function _event_before_update()
    {
        $this->updated_at = \Myclasses\FNC::currentdbtime();
        $this->updated_by = \Acl\Acl::current_user_id();
    }

}

?>
