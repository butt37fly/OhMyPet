<?php 

require "config.php";

if( $_GET['action'] === "delete" && isset($_GET['id']) ){
  delete_product( $_GET['id'] );
  redirect( "", true);
  return;
}

if( isset($_POST['createProduct']) ){
  $result = create_product( $_POST );
  if( gettype($result) === 'string' ){
    session_start();
    $_SESSION['msg'] = array( "content" => $result, "type" => "error" );
    redirect( "", true );
    return;
  }
}




?>