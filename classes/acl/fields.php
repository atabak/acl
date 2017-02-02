<?php

namespace Acl;

class Fields
{

    public static function group_field_name($group_id)
    {
        $fields = Model_Field::query()->where('group_id', $group_id)->get();
        if ($fields)
        {
            $field_array = [];
            foreach ($fields as $fields)
            {
                
            }
        }
        return false;
    }

    public static function create_user_field($group_id, $size = null)
    {
        $fields = Model_Group_Field::query()
                ->where('group_id', $group_id)
                ->order_by('order')
                ->get();
        if ($fields)
        {
            $return = '';
            foreach ($fields as $field)
            {
                $return .= '
                    <div class="col-lg-'.($size ? : $field->size).'">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", array("class" => "control-label")).'
                            <div class="controls">
                                '.self::fieldcreator("ufld$field->id", $field->type_id, $field->default_values, $field->is_required).'
                            </div>
                        </div>
                    </div>
                ';
            }
            return $return;
        }
        return false;
    }

    public static function fieldcreator($name, $type_id, $default, $is_required, $value = null, $is_editable = false)
    {
        $editable = $is_editable ? ['disabled' => 'disable'] : '';
        switch ($type_id)
        {
            case 1:
                if ($is_editable)
                {
                    return \Form::input($name, $value, array("class" => "form-control", 'placeholder' => $default, 'disabled' => 'disable'));
                }
                else
                {
                    return \Form::input($name, $value, array("class" => "form-control", 'placeholder' => $default));
                }
            case 2:
                if ($is_editable)
                {
                    return \Form::input($name, $value, array("class" => "form-control pd", 'placeholder' => $default, 'disabled' => 'disable'));
                }
                else
                {
                    return \Form::input($name, $value, array("class" => "form-control pd", 'placeholder' => $default));
                }
            case 3:
                if ($is_editable)
                {
                    return \Form::input($name, $value, array("class" => "form-control ed", 'placeholder' => $default, 'disabled' => 'disable'));
                }
                else
                {
                    return \Form::input($name, $value, array("class" => "form-control ed", 'placeholder' => $default));
                }
            case 4:
                return \Form::file($name);
            case 5:
                $default = unserialize($default);
                if (!$is_required)
                {
                    $default = array('' => '') + $default;
                }
                if ($is_editable)
                {
                    return \Form::input($name, $value, array("class" => "form-control ed", 'disabled' => 'disable'));
                }
                else
                {
                    return \Form::select($name, $value, $default, array("class" => "form-control"));
                }
            case 6:
                if ($is_editable)
                {
                    return \Form::textarea($name, ($value ? $value : $default), array("class" => "form-control", 'disabled' => 'disable'));
                }
                else
                {
                    return \Form::textarea($name, ($value ? $value : $default), array("class" => "form-control"));
                }
        }
    }

    public static function user_profile_fields()
    {
        $user   = Acl::current_user();
        $fields = Model_Group_Field::query()
                ->where('group_id', $user->group_id)
                ->order_by('order')
                ->get();
        if ($fields)
        {
            $return = '';
            foreach ($fields as $field)
            {
                $value = Model_Group_Field_Values::query()
                        ->where('user_id', $user->id)
                        ->where('field_id', $field->id)
                        ->get_one();
                $return .= '
                    <div class="col-lg-'.$field->size.'">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", array("class" => "control-label")).'
                            <div class="controls">
                                '.self::fieldcreator("ufld$field->id", $field->type_id, $field->default_values, $field->is_required, ($value ? $value->value : null), ($field->is_editable ? true : false)).'
                            </div>
                        </div>
                    </div>
                ';
            }
            return $return;
        }
        return false;
    }

    public static function user_edit_fields($user_id, $size = null)
    {
        $user   = Model_User::find($user_id);
        $fields = Model_Group_Field::query()
                ->where('group_id', $user->group_id)
                ->order_by('order')
                ->get();
        if ($fields)
        {
            $return = '';
            foreach ($fields as $field)
            {
                $value = Model_Group_Field_Values::query()
                        ->where('user_id', $user->id)
                        ->where('field_id', $field->id)
                        ->get_one();
                $return .= '
                    <div class="col-lg-'.($size ? : $field->size).'">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", array("class" => "control-label")).'
                            <div class="controls">
                                '.self::fieldcreator("ufld$field->id", $field->type_id, $field->default_values, $field->is_required, ($value ? $value->value : null)).'
                            </div>
                        </div>
                    </div>
                ';
            }
            return $return;
        }
        return false;
    }

}
