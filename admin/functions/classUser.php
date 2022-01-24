<?php

class User extends Db_table
{
    protected static $db_table = "users";
    protected static $db_table_fields = array('user_name', 'user_password', 'first_name', 'last_name');
    protected static $db_table_fields_type = 'ssss';
    protected static $db_id = 'id_user';

    // Valore creados acorde a las columnas de la tabla users
    public $id_user;
    public $user_name;
    public $user_password;
    public $first_name;
    public $last_name;

    // Verifica si existe el usuario en la tabla
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name = '{$username}' AND user_password = '{$password}'";

        $result_user = self::find_by_query($sql);

        if ($result_user) {
            foreach ($result_user as $user) {
                return $user;
            }
        } else {
            return false;
        }
    }
}
