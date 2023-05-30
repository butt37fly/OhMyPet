<?php
 
session_start(); 
// unset($_SESSION['cart']);
print_r($_SESSION['cart']);
  
?>

<h1>categorias</h1>

<?php get_template( 'store' ) ?>