<?php require "inc/config.php"; ?>

<?php get_header()?>

<?php 
  session_start(); 
  // unset($_SESSION['cart']);
  print_r($_SESSION['cart']);
  
  ?>

  <section class="Main">

    <?php get_template( 'store' ) ?>

  </section>

<?php get_footer()?>
