<?php 


/** 
 * Obtiene el título de la página actual 
 * @return string 
 */
function get_title(){
  return SITE_TITLE;
}

/**
 * Añade archivos css o js
 * 
 * @param string $name Nombre del fichero a incluir
 * @param string $type Tipo del fichero a incluir
 * 
 * @return string Url del fichero solicitado
 */
function get_script( string $name , string $type ){
  $directories = [
    "css" => CSS_URI,
    "js" => JS_URI
  ];
  $directory = $directories[$type];
  $file_uri = $directory .$name .".$type";

  if( !$directory){
    return "¡Error! El directorio no existe";
  }

  return $file_uri;
}

/**
 * Incluye una plantilla de la carpeta `php/templates`
 * 
 * @param string $name Nombre de la plantilla solicitada
 * 
 * @return mixed Include del fichero
 */
function get_template( string $name ){
  $templates_path = 'src/php/templates/';
  $file_path = ROOT_PATH . $templates_path .$name .".php";

  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El directorio no existe";
}