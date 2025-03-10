<?php
// Carrito.php

//@authotr:Ricardo Gómez 
require_once 'Producto.php';

class Carrito {
    /**
     * Almacena los productos del carrito.
     * Formato: [ idProducto => [ 'producto' => Producto, 'cantidad' => int ] ]
     */
    private $productos;

    public function __construct() {
        $this->productos = [];
    }

    /**
     * Agrega un producto al carrito.
     * Si el producto ya existe, suma la cantidad.
     * Lanza Exception con código 400 si la cantidad es <= 0.
     */
    public function agregarProducto(Producto $producto, $cantidad) {
        if ($cantidad <= 0) {
            throw new Exception("Cantidad inválida", 400);
        }
        $id = $producto->getId();
        if (isset($this->productos[$id])) {
            $this->productos[$id]['cantidad'] += $cantidad;
        } else {
            $this->productos[$id] = [
                'producto' => $producto,
                'cantidad' => $cantidad
            ];
        }
    }

    /**
     * Elimina un producto del carrito.
     * Lanza OutOfBoundsException con código 404 si el producto no existe.
     */
    public function eliminarDelCarrito(Producto $producto) {
        $id = $producto->getId();
        if (!isset($this->productos[$id])) {
            throw new OutOfBoundsException("Producto no encontrado", 404);
        }
        unset($this->productos[$id]);
    }

    /**
     * Actualiza la cantidad de un producto en el carrito.
     * Lanza Exception con código 400 si la cantidad es <= 0.
     * Lanza OutOfBoundsException con código 404 si el producto no existe.
     */
    public function actualizarCarrito(Producto $producto, $cantidad) {
        if ($cantidad <= 0) {
            throw new Exception("Cantidad inválida", 400);
        }
        $id = $producto->getId();
        if (!isset($this->productos[$id])) {
            throw new OutOfBoundsException("Producto no encontrado", 404);
        }
        $this->productos[$id]['cantidad'] = $cantidad;
    }

    /**
     * Calcula el total del carrito.
     * Suma cantidad * precio de cada producto.
     */
    public function calcularTotal() {
        $total = 0;
        foreach ($this->productos as $entry) {
            $total += $entry['producto']->getPrecio() * $entry['cantidad'];
        }
        return $total;
    }
}
