<?php

class DB
{
    // Inicializando la variable conexion
    public $conn;

    public function __construct($host, $user, $password, $database)
    {
        $this->conn = new mysqli($host, $user, $password, $database);
        $this->conn->set_charset("utf8");

        if ($this->conn->connect_error) {
            $error = $this->conn->connect_error;
            echo $error;
        }
    }

    // Consulta de datos

    public function query_consult($consulta)
    {
        try {
            $stmt = $this->conn->query($consulta);
            return $stmt;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

    // Modificar registros en la base de datos

    public function query_modify($consulta, $tipo_datos, $parametros)
    {
        try {
            $stmt = $this->conn->prepare($consulta);
            call_user_func_array(array($stmt, "bind_param"), array_merge(array($tipo_datos), $parametros));
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            echo "Error! : " . $e->getMessage();
            return false;
        }
    }

    public function close_query($stmt)
    {
        $stmt->close();
        $this->conn->close();
    }
}
