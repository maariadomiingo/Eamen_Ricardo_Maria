<?php

class Nombre
{
    private $conn;

    public function __construct()
    {
        $servidor = "localhost";
        $usuario = "root";
        $password = "";
        $base_datos = "usuarios";

        // Conexión a MySQL
        $this->conn = new mysqli($servidor, $usuario, $password);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        // Verificar si la base de datos existe
        $sql = "SHOW DATABASES LIKE '$base_datos'";
        $resultado = $this->conn->query($sql);

        if ($resultado->num_rows == 0) {
            // Crear la base de datos si no existe
            $sql = "CREATE DATABASE $base_datos";
            if (!$this->conn->query($sql)) {
                die("Error al crear la base de datos: " . $this->conn->error);
            }
        }

        // Seleccionar la base de datos
        $this->conn->select_db($base_datos);

        // Crear la tabla `clientes` si no existe
        $sql = "CREATE TABLE IF NOT EXISTS clientes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(255) NOT NULL
        )";

        if (!$this->conn->query($sql)) {
            die("Error al crear la tabla: " . $this->conn->error);
        }
    }

    public function introduceNombre($nombre)
    {
        $stmt = $this->conn->prepare("INSERT INTO clientes (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->close();
    }

    public function borraNombre($nombre)
    {
        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->close();
    }

    public function compruebaNombre($nombre)
    {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            throw new Exception('Not Found');
        }

        $stmt->close();
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

?>
