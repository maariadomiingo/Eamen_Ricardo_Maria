<?php
# Archivo: src/Nombre.php

class Nombre {
    private $conexion;

    public function __construct() {
        $this->conexion = null;
    }

    public function conectarBD() {
        try {
            $host = 'localhost'; // Define el host
            $usuario = 'root';   // Cambia esto por tu usuario de MySQL
            $contrasena = '';    // Cambia esto por tu contraseña de MySQL
            $db = 'usuarios';

            // Intentamos conectarnos al servidor MySQL
            $this->conexion = new PDO("mysql:host=$host", $usuario, $contrasena);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Verificamos si existe la base de datos "usuarios"
            $this->crearBaseDeDatos();
            $this->seleccionarBaseDeDatos();
            $this->crearTabla();

            return true;
        } catch (PDOException $e) {
            echo 'Error al conectar con el servidor MySQL: ' . $e->getMessage();
            return false;
        }
    }

    private function crearBaseDeDatos() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS usuarios;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            echo "Base de datos 'usuarios' creada correctamente o ya existe.\n";
        } catch (PDOException $e) {
            echo 'Error al crear la base de datos: ' . $e->getMessage();
            throw $e;
        }
    }

    private function seleccionarBaseDeDatos() {
        try {
            $sql = "USE usuarios;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            echo "Se ha seleccionado la base de datos 'usuarios'.\n";
        } catch (PDOException $e) {
            echo 'Error al seleccionar la base de datos: ' . $e->getMessage();
            throw $e;
        }
    }

    private function crearTabla() {
        try {
            $sql = "
                CREATE TABLE IF NOT EXISTS clientes (
                    nombre VARCHAR(255)
                );
            ";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            echo "Tabla 'clientes' creada correctamente o ya existe.\n";
        } catch (PDOException $e) {
            echo 'Error al crear la tabla clientes: ' . $e->getMessage();
            throw $e;
        }
    }

    public function desconectarBD() {
        try {
            $this->conexion = null;
            echo "Conexión cerrada con éxito.\n";
        } catch (PDOException $e) {
            echo 'Error al cerrar la conexión: ' . $e->getMessage();
        }
    }

    public function introduceNombre($nombre) {
        try {
            if ($this->conexion === null) {
                throw new Exception('No se ha establecido una conexión con la base de datos.');
            }

            $sql = "INSERT INTO clientes (nombre) VALUES (:nombre)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            
            echo "Nombre '$nombre' insertado correctamente.\n";
            return true;
        } catch (PDOException $e) {
            echo 'Error al insertar el nombre: ' . $e->getMessage();
            return false;
        }
    }

    public function borraNombre($nombre) {
        try {
            if ($this->conexion === null) {
                throw new Exception('No se ha establecido una conexión con la base de datos.');
            }

            $sql = "DELETE FROM clientes WHERE nombre = :nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            
            echo "Nombre '$nombre' eliminado correctamente.\n";
            return true;
        } catch (PDOException $e) {
            echo 'Error al eliminar el nombre: ' . $e->getMessage();
            return false;
        }
    }

    public function compruebaNombre($nombre) {
        try {
            if ($this->conexion === null) {
                throw new Exception('No se ha establecido una conexión con la base de datos.');
            }

            $sql = "SELECT * FROM clientes WHERE nombre = :nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultado) === 0) {
                throw new NotFoundException("El nombre '$nombre' no existe en la base de datos.");
            }
            
            echo "Nombre '$nombre' encontrado en la base de datos.\n";
            return true;
        } catch (PDOException $e) {
            echo 'Error al verificar el nombre: ' . $e->getMessage();
            return false;
        }
    }
}

class NotFoundException extends Exception {}
?>