<?php

namespace App\Models;


class Cart
{

    // Agregar producto al carrito
    public static function add(Product $product){
        // add the product to cart
        \Cart::session(userID())->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->precio_venta,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $product
        ));

    }



    // obtener el contenido del carrito
    public static function getCart(){
        $cart = \Cart::session(userID())->getContent();
        return $cart->sort();
    } 

    // Devolver total
    public static function getTotal(){
        return \Cart::session(userID())->getTotal();
    }

    // Disminuir cantidad
    public static function dismin($id){
        \Cart::session(userID())->update($id,[
            'quantity' => -1
        ]);
    }

    // Aumentar cantidad
    public static function aumentar($id){
        \Cart::session(userID())->update($id,[
            'quantity' => +1
        ]);
    }

    // Eliminar el item del carrito
    public static function remove($id){
        \Cart::session(userID())->remove($id);
    }

    // limpiar carrito
    public static function clear(){
        \Cart::session(userID())->clear();
    }

    // Total de articulos
    public static function totalArticulos(){
       return \Cart::session(userID())->getTotalQuantity();
    }

}


