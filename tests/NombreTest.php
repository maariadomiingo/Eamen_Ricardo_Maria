<?php
require_once './src/NombreBBDD.php';

try {
    $nombre = new Nombre();
    $conexion = $nombre->conectarBD();
    
    if ($conexion) {
        echo "Conexión exitosa a la base de datos y tabla creadas.\n";
        
        // Prueba 1: Insertar un nombre
        $insertado = $nombre->introduceNombre('Juan');
        if ($insertado) {
            echo "Nombre 'Juan' insertado correctamente.\n";
        }
        
        // Prueba 2: Verificar si existe un nombre
        $existe = $nombre->compruebaNombre('Juan');
        if ($existe) {
            echo "Nombre 'Juan' existe en la base de datos.\n";
        }
        
        // Prueba 3: Eliminar un nombre
        $eliminado = $nombre->borraNombre('Juan');
        if ($eliminado) {
            echo "Nombre 'Juan' eliminado correctamente.\n";
        }
        
        // Prueba 4: Verificar un nombre que no existe
        try {
            $nombre->compruebaNombre('Pedro');
        } catch (NotFoundException $e) {
            echo $e->getMessage() . "\n";
        }
        
        $nombre->desconectarBD();
        echo "Conexión cerrada con éxito.\n";
    } else {
        echo "No se pudo establecer la conexión.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>