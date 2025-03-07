<?php
use PHPUnit\Framework\TestCase;

require_once 'src/NombreBBDD.php'; // Incluir la clase

class NombreTest extends TestCase
{
    private $nombre;

    // Configurar antes de cada prueba
    protected function setUp(): void
    {
        // Se inicializa la clase Nombre antes de cada prueba
        $this->nombre = new Nombre();
    }

    // Probar la inserción de un nombre en la base de datos
    public function testIntroduceNombre()
    {
        // Insertar un nombre en la base de datos
        $this->nombre->introduceNombre("Juan");

        // No hay una salida visible, pero si no hay errores, la prueba pasa
        $this->expectNotToPerformAssertions();
    }

    // Probar la eliminación de un nombre de la base de datos
    public function testBorraNombre()
    {
        // Eliminar un nombre de la base de datos
        $this->nombre->borraNombre("Juan");

        // No hay una salida visible, pero si no hay errores, la prueba pasa
        $this->expectNotToPerformAssertions();
    }

    // Probar que lanza la excepción cuando el nombre no se encuentra
    public function testCompruebaNombreNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not Found');
        
        // Probar un nombre que no existe en la base de datos
        $this->nombre->compruebaNombre("NombreInexistente");
    }

    // Cerrar la conexión después de cada prueba
    protected function tearDown(): void
    {
        // Cierra la conexión a la base de datos después de cada prueba
        $this->nombre->closeConnection();
    }
}
?>
