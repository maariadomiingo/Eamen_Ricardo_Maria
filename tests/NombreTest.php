<?php
use PHPUnit\Framework\TestCase;

require_once 'src/NombreBBDD.php'; // Incluir la clase

class NombreTest extends TestCase
{
    private $nombre;

    // Configurar antes de cada prueba
    protected function setUp(): void
    {
        $this->nombre = new Nombre();
    }

    // Probar la inserción de un nombre en la base de datos
    public function testIntroduceNombre()
    {
        $this->nombre->introduceNombre("Juan");
        $this->expectNotToPerformAssertions(); // No hay una salida visible, pero si no hay errores, pasa
    }

    // Probar la eliminación de un nombre de la base de datos
    public function testBorraNombre()
    {
        $this->nombre->borraNombre("Juan");
        $this->expectNotToPerformAssertions(); // No hay una salida visible, pero si no hay errores, pasa
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
        $this->nombre->closeConnection();
    }
}
?>
