<?php
//@authotr:Ricardo Gómez 

// CarritoTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Carrito.php';
require_once __DIR__ . '/../src/Producto.php';

class CarritoTest extends TestCase {

    public function testAgregarProductoNuevo() {
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        $carrito->agregarProducto($producto, 2);
        $this->assertEquals(20.0, $carrito->calcularTotal());
    }

    public function testAgregarProductoExistente() {
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        $carrito->agregarProducto($producto, 2);
        // Se agrega el mismo producto y se suma la cantidad
        $carrito->agregarProducto($producto, 3);
        $this->assertEquals(50.0, $carrito->calcularTotal());
    }

    public function testAgregarProductoCantidadInvalida() {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(400);
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        // Cantidad inválida: 0
        $carrito->agregarProducto($producto, 0);
    }

    public function testEliminarProductoExistente() {
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        $carrito->agregarProducto($producto, 2);
        $carrito->eliminarDelCarrito($producto);
        $this->assertEquals(0, $carrito->calcularTotal());
    }

    public function testEliminarProductoNoExistente() {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionCode(404);
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        // Intento de eliminar producto que no se agregó
        $carrito->eliminarDelCarrito($producto);
    }

    public function testActualizarProductoExistente() {
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        $carrito->agregarProducto($producto, 2);
        $carrito->actualizarCarrito($producto, 5);
        $this->assertEquals(50.0, $carrito->calcularTotal());
    }

    public function testActualizarProductoCantidadInvalida() {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(400);
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        $carrito->agregarProducto($producto, 2);
        // Cantidad inválida: 0
        $carrito->actualizarCarrito($producto, 0);
    }

    public function testActualizarProductoNoExistente() {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionCode(404);
        $producto = new Producto(1, "Producto 1", 10.0);
        $carrito = new Carrito();
        // Intento de actualizar producto que no se encuentra en el carrito
        $carrito->actualizarCarrito($producto, 5);
    }
}
