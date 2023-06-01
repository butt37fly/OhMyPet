<?php 

function db_connect(){
  $link = 'mysql:host=localhost;dbname=store';
  $user ='root';
  $password = '';

  try{
    $pdo = new PDO ($link,$user,$password);
  }catch(PDOException $e) {
    $pdo = "¡Error!: " . $e->getMessage();
    die();
  }
  
  return $pdo;
}