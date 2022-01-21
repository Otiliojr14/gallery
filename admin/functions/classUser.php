<?php

class User
{

    public $id_user;
    public $user_name;
    public $user_password;
    public $first_name;
    public $last_name;

    public static function find_all_users()
    {
        return self::query_consult("SELECT * FROM users");
    }

    public static function find_user_by_id($user_id)
    {
        $result_user = self::query_consult("SELECT * FROM users WHERE id_user = {$user_id} LIMIT 1");

        if (!empty($result_user)) {
            foreach ($result_user as $user) {
                return $user;
            }
        } else {
            return false;
        }
    }

    public static function query_consult($sql)
    {
        global $conn;
        $object_array = array();

        $result_set = $conn->query_consult($sql);

        foreach ($result_set as $row) {

            // Crea un objeto para cada registro
            $object_array[] = self::instatiation($row);
        }

        return $object_array;
    }

    public static function instatiation($row)
    {
        $object = new self;

        foreach ($row as $attribute => $value) {
            if ($object->has_the_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    private function has_the_attribute($attribute)
    {
        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }
}
