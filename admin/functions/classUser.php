<?php

class User
{
    protected static $db_table = "users";
    protected static $db_table_fields = array('user_name', 'user_password', 'first_name', 'last_name');
    protected static $db_table_fields_type = 'ssss';

    // Valore creados acorde a las columnas de la tabla users
    public $id_user;
    public $user_name;
    public $user_password;
    public $first_name;
    public $last_name;

    // Método que permite encontrar todos los usuarios registrados
    public static function find_all_users()
    {
        return self::query_consult("SELECT * FROM users");
    }

    // Método que permite encontrar un usuario por su id
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

    // Verifica si existe el usuario en la tabla
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE user_name = '{$username}' AND user_password = '{$password}'";

        $result_user = self::query_consult($sql);

        if ($result_user) {
            foreach ($result_user as $user) {
                return $user;
            }
        } else {
            return false;
        }
        
    }

    // Método para ejecutar consultas a MySQL
    public static function query_consult($sql)
    {
        global $conn;
        $object_array = array();

        try {
            $result_set = $conn->query_consult($sql);

            foreach ($result_set as $row) {

                // Crea un objeto para cada registro
                $object_array[] = self::instatiation($row);
            }
    
            return $object_array;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
        
    }

    // Crea un objeto de esta clase basado en el registro encontrado en MySQL
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


    // Verifica si la columna del registro coincide con los atributos de esta clase
    private function has_the_attribute($attribute)
    {
        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }

    protected function get_fields()
    {
        $properties = array();

        foreach (self::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;

    }

    public function save()
    {
        return isset($this->id_user) ? $this->update() : $this->create();
    }

    public function create()
    {
        global $conn;

        $properties = filter_var_array($this->get_fields(), FILTER_SANITIZE_STRING);
        $keys = implode(", ", array_keys($properties));
        $data = array_values($properties);        
       
        try {
            $query = "INSERT INTO " . self::$db_table . "  ({$keys}) VALUES (?, ?, ?, ?)";
            $type = self::$db_table_fields_type;
            $stmt = $conn->conn->prepare($query);
            $stmt->bind_param($type, ...$data);
            $stmt->execute();

            if ($stmt->affected_rows) {
                $this->id_user = $stmt->insert_id;

                echo $this->id_user;
                return true;
            } else {
                return false;
            }
            
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

    public function update()
    {
        global $conn;

        $id = $this->id_user;
        $properties = $this->get_fields();
        $properties = filter_var_array($properties, FILTER_SANITIZE_STRING);

        $properties_pairs = array();

        $data = array_values($properties);

        // Agrega el id al array de datos del registro
        array_push($data, (int) $id);

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key} = ?";
        }

        $properties_sql = implode(", ", $properties_pairs);

        try {
            $query = "UPDATE " . self::$db_table . " SET {$properties_sql} WHERE id_user = ? ";
            $type = self::$db_table_fields_type . "i";

            $stmt = $conn->conn->prepare($query);
            $stmt->bind_param($type, ...$data);
            $stmt->execute();

            return ($stmt->affected_rows) ? true : false;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }

    }

    public function delete()
    {
        global $conn;

        $id = $this->id_user;

        try {
            $query = "DELETE FROM " . self::$db_table . " WHERE id_user = ? LIMIT 1";
            $type = 'i';
            $data = array(&$id);

            $stmt = $conn->conn->prepare($query);
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($type), $data));
            $stmt->execute();

            return ($stmt->affected_rows) ? true : false;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }
}
