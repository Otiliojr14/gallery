<?php

class Db_table
{
    // Método que permite encontrar todos los usuarios registrados
    public static function find_all()
    {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
    }

    // Método que permite encontrar un usuario por su id
    public static function find_by_id($id)
    {
        $results = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE " . static::$db_id . "  = {$id} LIMIT 1");

        if (!empty($results)) {
            foreach ($results as $result) {
                return $result;
            }
        } else {
            return false;
        }
    }

    // Método para ejecutar consultas a MySQL
    public static function find_by_query($sql)
    {
        global $conn;
        $object_array = array();

        try {
            $result_set = $conn->query_consult($sql);

            foreach ($result_set as $row) {

                // Crea un objeto para cada registro
                $object_array[] = static::instatiation($row);
            }

            return $object_array;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

    public static function instatiation($row)
    {
        $calling_class = get_called_class();

        $object = new $calling_class;

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

    protected function get_fields()
    {
        $properties = array();

        foreach (static::$db_table_fields as $db_field) {
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

        // Añade los signos de interrogación dependiendo el número de columnas a insertar
        $values_array = array();

        foreach ($properties as $key) {
            $values_array[] = "?";
        }

        $values = implode(", ", $values_array);

        try {
            $query = "INSERT INTO " . static::$db_table . "  ({$keys}) VALUES ({$values})";
            $type = static::$db_table_fields_type;
            $stmt = $conn->conn->prepare($query);
            $stmt->bind_param($type, ...$data);
            $stmt->execute();

            if ($stmt->affected_rows) {
                $this->id_user = $stmt->insert_id;

                // echo $this->id_user;
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
            $query = "UPDATE " . static::$db_table . " SET {$properties_sql} WHERE id_user = ? ";
            $type = static::$db_table_fields_type . "i";

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
            $query = "DELETE FROM " . static::$db_table . " WHERE id_user = ? LIMIT 1";
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
