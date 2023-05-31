<?php 

require "config.php";

if( isset($_POST['createUser']) ){

  $result = create_user( $_POST );
  if( gettype($result) === 'string' ){
    session_start();
    $_SESSION['msg'] = array( "content" => $result, "type" => "error" );
    redirect( "", true );
    return;
  }
}

if( isset($_POST['validateUser']) ){

  $result = validate_user( $_POST );
  if( gettype($result) === 'string' ){
    session_start();
    $_SESSION['msg'] = array( "content" => $result, "type" => "error" );
    redirect( "", true );
    return;
  }
}

if( isset($_GET['logout'] )){
  logout_user();
  return;
}



