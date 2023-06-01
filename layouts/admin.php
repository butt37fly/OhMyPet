<section class="Admin">

  <?php 
  
  $view = $_GET['view'];
  
  if( !is_logedin() ){ redirect(); } 
  
  if( $view === "products" ){

    get_template( "admin/products" );
    
  } else {

    redirect();

  } ?>

</section>