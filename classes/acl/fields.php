<?php

namespace Acl;

class Fields
{

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
                    <div class="col-lg-'.($size ?: $field->size).'">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", ["class" => "control-label"]).'
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

    public static function groupSearchFields($group_id)
    {
        $fields = Model_Group_Field::query()
                ->where('group_id', $group_id)
                ->order_by('order')
                ->get();

        $return = '';

        if ($fields)
        {
            foreach ($fields as $field)
            {
                $return .= '
                    <div class="col-md-12">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", ["class" => "control-label"]).'
                            <div class="controls">
                                '.self::groupSearchFieldCreator("ufld$field->id", $field->type_id, $field->default_values).'
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        else
        {
            $return = '<div class="col-md-12 text-center">برای این گروه کاربری فیلدی تعریف نشده است</div>';
        }

        return $return;
    }

    public static function groupSearchFieldCreator($name, $type, $default)
    {
        switch ($type)
        {
            case 1:
            case 6:
                return \Form::input($name, null, ["class" => "form-control", 'placeholder' => $default]);
            case 2:
                return \Form::input($name, null, ["class" => "form-control pd", 'placeholder' => $default]);
            case 3:
                return \Form::input($name, null, ["class" => "form-control ed", 'placeholder' => $default]);
            case 5:
                $default = ['' => ''] + unserialize($default);
                return \Form::select($name, null, $default, ["class" => "form-control"]);
            case 7:
                $data    = unserialize($default);
                $select  = [];
                $select  = ['' => ''];
                $results = \DB::select(trim($data[2]), trim($data[3]))
                        ->from(trim($data[1]))
                        ->execute();
                if ($results)
                {
                    foreach ($results as $res)
                    {
                        $select[$res[trim($data[3])]] = $res[trim($data[2])];
                    }
                }
                return \Form::select($name, null, $select, ["class" => "form-control"]);
        }
    }

    public static function fieldcreator($name, $type_id, $default, $is_required, $value = null, $is_editable = true)
    {
        $req = $is_required ? 'required' : '';

        $edit = $is_editable ? '' : 'disabled';

        switch ($type_id)
        {
            case 1:
                return \Form::input($name, $value, ["class" => "form-control", 'placeholder' => $default, $edit, $req]);
            case 2:
                return \Form::input($name, $value, ["class" => "form-control pd", 'placeholder' => $default, $edit, $req]);
            case 3:
                return \Form::input($name, $value, ["class" => "form-control ed", 'placeholder' => $default, $edit, $req]);
            case 4:
                return \Form::file($name);
            case 5:
                $default = unserialize($default);
                if (!$is_required)
                {
                    $default = ['' => ''] + $default;
                }
                return \Form::select($name, $value, $default, ["class" => "form-control", $edit, $req]);
            case 6:
                return \Form::textarea($name, ($value ? $value : $default), ["class" => "form-control", $edit, $req]);
            case 7:
                $data   = unserialize($default);
                $select = [];
                if (!$is_required)
                {
                    $select = ['' => ''];
                }
                $results = \DB::select(trim($data[2]), trim($data[3]))
                        ->from(trim($data[1]))
                        ->execute();
                if ($results)
                {
                    foreach ($results as $res)
                    {
                        $select[$res[trim($data[3])]] = $res[trim($data[2])];
                    }
                }
                return \Form::select($name, $value, $select, ["class" => "form-control", $edit, $req]);
        }
    }

    /**
     * return current user group field for edit in profile
     * add access
     * @return boolean|string
     */
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
                            '.\Form::label($field->label, "ufld$field->id", ["class" => "control-label"]).'
                            <div class="controls">
                                '.self::fieldcreator("ufld$field->id", $field->type_id, $field->default_values, $field->is_required, ($value ? $value->value : null), $field->is_editable).'
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
        $user = Model_User::find($user_id);

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
                    <div class="col-lg-'.($size ?: $field->size).'">
                        <div class="control-group">
                            '.\Form::label($field->label, "ufld$field->id", ["class" => "control-label"]).'
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
