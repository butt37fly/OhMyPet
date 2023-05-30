<?php 

# Funciones generales

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
 * Incluye una plantilla de la carpeta `layouts`
 * 
 * @param string $name Nombre de la plantilla solicitada
 * 
 * @return mixed Include del fichero
 */
function get_template( string $name ){
  $file_path = LAYOUTS_PATH .$name .".php";

  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El directorio no existe";
}

/**
 * Carga el header del sitio ubicado en la carpeta `layouts`
 */
function get_header(){
  $file_path = LAYOUTS_PATH ."header/header.php";
  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El fichero no existe";
}

/**
 * Carga el footer del sitio ubicado en la carpeta `layouts`
 */
function get_footer(){
  $file_path = LAYOUTS_PATH ."footer.php";
  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El fichero no existe";
}

/**
 * Obtiene un elemento html con los enlaces del menú de navegación del header
 * 
 * @return string
 */
function get_page_nav(){
  $pages = [ 
    [
      "title" => "Inicio",
      "link" => HOME
    ],
    [
      "title" => "Tienda",
      "link" => STORE
    ],
    [
      "title" => "Contacto",
      "link" => CONTACT
    ]
  ];
  $links = "";

  foreach ($pages as $key) {
    $links .= "<li class='Header__nav__item'><a class='Header__nav__link' href='$key[link]'>$key[title]</a></li>";
  }

  return "<ul class='Header__nav'>$links</ul>";
}

function get_url_vars( string $var = '' ){
  if( isset($_GET) ){
    print_r( $_GET );
  }
}

/**
 * Función general para redireccionar al usuario a las diferentes páginas del sitio
 * 
 * @param string $page_title Si no se especifica ninguna página, redirecciona al inicio
 */
function redirect( string $page_title = "" ){
  $pages = [
    'store' => STORE,
    'contact' => CONTACT
  ];

  $target = $pages[$page_title] ? $pages[$page_title] : SITE_URL;

  header("Location: $target");
  return;
}

# Funciones de la tienda

/**
 * Añade productos o actualiza el carrito de compras
 * 
 * @param array $cart Array del carrito de compras
 * @param array $item Información del producto que se añadirá o actualizará
 * 
 * @return mixed Carrito de compras actualizado
 */
function set_value( array $cart, array $item ){

  $id = $item['id'];
  $units = $item['units'];
  $max = $item['max'];

  // Finaliza si uno de los dos parámetros está vacío
  if( empty($id) || empty($units) ){ return null; }

  foreach ($cart as $key => $product) {
    // Si el producto ya existe en el carrito, actualiza las unidades
    if ( $product['id'] === $id ){
      $new_quantity = $cart[$key]['units'] + $units;
      $cart[$key]['units'] = $new_quantity >= $max ? $max : $new_quantity; 

      return $cart;
    }
  }
  
  $cart[] = array( "id" => $id, "units" => $units );
  return $cart;
}

/**
 * Devuelve un arreglo con la información de los productos consultados
 * 
 * @param int $category_id Especifica el id de una categoría para filtrar los productos
 * @return mixed
 */
function get_products( int $category_id = 0 ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  if( $category_id !== 0 ){
    $query = 'SELECT * FROM `products` WHERE category = :category_id';
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':category_id', $category_id );

  } else {
    $query = 'SELECT * FROM `products`';
    $consult = $pdo->prepare( $query );
  }

  $consult->execute();
  $result = $consult->fetchAll();
  
  $pdo = null;
  $consult = null;

  return $result;
}

function get_category( mixed $category ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  # Si no se especifica ni un id ni un slug
  if ( !$category || empty($category) ){ 
    return false; 
  }

  if ( gettype($category) === 'integer' && $category !== 0 ){
    $query = 'SELECT * FROM `categories` WHERE id = :category_id';
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':category_id', $category );
    
  } else {
    $query = 'SELECT * FROM `categories` WHERE slug = :category_slug';
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':category_slug', $category );
  }

  $consult->execute();
  $result = $consult->fetch();
  
  $pdo = null;
  $consult = null;

  return $result;
}

function get_pet( int $pet_id ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  # Si no se especifica ni un id ni un slug
  if ( !$pet_id ){ 
    return false; 
  }
  
  $query = 'SELECT * FROM `pets` WHERE id = :pet_id';
  $consult = $pdo->prepare( $query );
  $consult->bindValue( ':pet_id', $pet_id );
  $consult->execute();
  $result = $consult->fetch();
  
  $pdo = null;
  $consult = null;

  return $result;
}

/**
 * Devuelve una cadena html con los items consultados
 * 
 * @param array $products Arreglo con la información de los productos a imprimir en pantalla
 * @return string
 */
function the_products( array $products ){

  $output = "";
  $icon_classes = [
    "Mascota" => [
      "Gato" => "fa-cat",
      "Perro" => "",
    ],
    "Categoria" => [
      "Aseo" => "",
      "Alimento" => "",
      "Deporte" => ""
    ]
  ];

  foreach ($products as $product){

    $id = $product['id'];
    $name = $product['name'];
    $pet = get_pet( $product['pet'] );
    $category = get_category( $product['category'] );
    $price = $product['price'];
    $units = $product['units'];
    $content = $product['content'];
    $img = IMG_URI ."placeholder.png";

    $pet_icon = $icon_classes['Mascota'][$pet['name']];
    $category_icon = $icon_classes['Categoria'][$category['name']];
    $availability = $units > 0 
    ? "Disponible ($units)"
    : "Agotado";

    $output .= "
      <div class='Card'>
        <div class='Card__front'>
          <div class='Card__thumbnail'>
            <img class='Card__img' src='$img' alt=''>
            <h3 class='Card__title'>$name</h3>
            <p class='Card__price'>$$price</p>
          </div>
          <div class='Card__cart'>
            <div class='Card__meta'>
              <i class='Icon fa-solid fa-cart-plus'></i>
              <p class=''>$availability</p>
            </div>
          </div>
        </div>
        <div class='Card__back'>
          <div class='Card__info'>
            <span class='Card__pet'>
              <i class='fa-solid $pet_icon'></i>
              <p class=''>$pet[name]</p>
            </span>
            <span class='Card__category'>
              <i class='fa-solid $category_icon'></i>
              <p class=''>$category[name]</p>
            </span>
            <span class='Card__Content'>
              <i class='fa-solid fa-content'></i>
              <p class=''>$content</p>
            </span>
          </div>
          <form class='Cart' method='POST' action='../inc/cart.php'>
            <input type='hidden' name='id' value='$id'>
            <input type='hidden' name='units' value='0'>
            <input type='hidden' name='max' value='$units'>
            <div class='Qty'>
              <span class='Qty__display'>0</span>
              <span class='Qty__buttons'>
                <span class='Qty__button Qty__button--add'> + </span>
                <span class='Qty__button Qty__button--remove'> - </span>
              </span>
            </div>
            <input class='Cart__add Button' type='submit' name='addToCart' value='Agregar'>
          </form>
          <button class='Button Button--back'>Volver</button>
        </div>
      </div>
    ";
  }

  return $output;
}







