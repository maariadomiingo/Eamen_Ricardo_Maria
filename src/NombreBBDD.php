<?php

class Nombre
{
    private $conn;

    // Establece la conexión con la base de datos
    public function __construct()
    {
        try {
            // Establece la conexión a la base de datos "usuarios"
            $this->conn = new PDO('mysql:host=localhost;dbname=usuarios', 'root', 'password'); // Cambia "root" y "password" por tus credenciales
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }
    }

    // Introduce un nombre en la base de datos
    public function introduceNombre($nombre)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO clientes (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error al insertar el nombre: ' . $e->getMessage();
        }
    }

    // Borra un nombre de la base de datos
    public function borraNombre($nombre)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM clientes WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error al eliminar el nombre: ' . $e->getMessage();
        }
    }

    // Comprueba si un nombre existe en la base de datos
    public function compruebaNombre($nombre)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                throw new Exception('Not Found');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Cierra la conexión con la base de datos
    public function closeConnection()
    {
        $this->conn = null;
    }
}

?>
