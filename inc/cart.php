<?php

require "config.php";

# Para añadir productos o añadir unidades de un producto ya existente en el carrito de compras 
if(isset($_POST['addToCart'])){

  session_start();
  $cart = $_SESSION['cart'] ? $_SESSION['cart'] : [];   
  $updated_cart = update_cart( $cart, $_POST );

  if( $updated_cart !== null ){
    $_SESSION['cart'] = $updated_cart;
  }

  redirect( "", true );
  return;
}

# Para actualizar las unidades de un producto del carrito de compras
if(isset($_POST['updateCart'])){

  session_start();
  $cart = $_SESSION['cart'];   
  $updated_cart = update_cart( $cart, $_POST, true );

  if( $updated_cart !== null ){
    $_SESSION['cart'] = $updated_cart;
  }

  redirect( "", true );
  return;
}

# Para remover un producto del carrito de compras
if(isset($_GET['id'])){
  
  session_start();
  $product_id = $_GET['id'];
  $cart = $_SESSION['cart'];

  if ( !isset($cart) ){ return; }

  $updated_cart = remove_cart_item( $cart, $product_id );

  $_SESSION['cart'] = $updated_cart;

  redirect( "", true );
  return;
}

redirect();

