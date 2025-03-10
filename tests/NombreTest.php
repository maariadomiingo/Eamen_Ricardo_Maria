<?php
//@author: María Domingo
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/NombreBBDD.php'; // Incluir la clase

class NombreTest extends TestCase
{
    private $nombre;

    // configuro antes de cada prueba 
    //utilizo setUp (requerido)
    protected function setUp(): void
    {
        try {
            $this->nombre = new Nombre();
        } catch (Exception $e) {
            $this->fail("Falló la conexión a la base de datos: " . $e->getMessage());
        }
    }

    // pruebp que se ha incluido un nombre en la base de datos
    public function testIntroduceNombre()
    {
        $this->nombre->introduceNombre("Juan");
        $this->expectNotToPerformAssertions();
    }

    // pruebo la eliminación de un nombre de la base de datos
    public function testBorraNombre()
    {
        $this->nombre->borraNombre("Juan");
        $this->expectNotToPerformAssertions();
    }

    // pruebp que lanza la excepción cuando el nombre no se encuentra
    public function testCompruebaNombreNotFound()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Not Found');
        
        $this->nombre->compruebaNombre("NombreInexistente");
    }

    // cieror la conexión después de cada prueba con tearDown
    protected function tearDown(): void
    {
        $this->nombre->closeConnection();
    }
}
?>
