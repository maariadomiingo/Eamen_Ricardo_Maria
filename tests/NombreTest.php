<?php
use PHPUnit\Framework\TestCase;

require_once 'C:/xampp/htdocs/PHPUnit_Ricardo_Maria/src/NombreBBDD.php'; // Incluir la clase

class NombreTest extends TestCase
{
    private $nombre;

    // Configurar antes de cada prueba
    protected function setUp(): void
    {
        try {
            $this->nombre = new Nombre();
        } catch (Exception $e) {
            $this->fail("Falló la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Probar la inserción de un nombre en la base de datos
    public function testIntroduceNombre()
    {
        $this->nombre->introduceNombre("Juan");
        $this->expectNotToPerformAssertions();
    }

    // Probar la eliminación de un nombre de la base de datos
    public function testBorraNombre()
    {
        $this->nombre->borraNombre("Juan");
        $this->expectNotToPerformAssertions();
    }

    // Probar que lanza la excepción cuando el nombre no se encuentra
    public function testCompruebaNombreNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not Found');
        
        $this->nombre->compruebaNombre("NombreInexistente");
    }

    // Cerrar la conexión después de cada prueba
    protected function tearDown(): void
    {
        $this->nombre->closeConnection();
    }
}
?>
