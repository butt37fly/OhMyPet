<?php

require "config.php";

# Para añadir productos o actualizar unidades del carrito de compras 
if (isset($_POST['addToCart'])){

  session_start();
  $cart = $_SESSION['cart'] ? $_SESSION['cart'] : [];   
  $updated_cart = set_value( $cart, $_POST );

  if( $updated_cart !== null ){
    $_SESSION['cart'] = $updated_cart;
  }

  redirect( "", true );
  return;
}

redirect();

