<section class="Admin">

  <?php 
  
  $view = $_GET['view'];
  
  if( !is_logedin() ){ redirect(); } 
  
  if( $view === "products" ){

    get_template( "admin/products" );
    
  } elseif ( $view === "users"){

    get_template( "admin/users" );

  } else {

    echo "si";

  } ?>

</section>