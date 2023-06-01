<?php 

# Funciones generales

/**
 * Define el nombre de la página actual del usuario 
 */
function get_page_active(){
  
  $page = $_GET['page'];
  
  if( !isset($page) ){ 
    return 'inicio'; 
  }

  if ( isset($_GET['pet']) || isset($_GET['category']) ){
    return 'tienda';
  } 

  return $page;
}

/** 
 * Obtiene el título de la página actual 
 * @return string 
 */
function get_title(){
  
  if ( empty(PAGE_ACTIVE) || PAGE_ACTIVE === 'inicio' ){ 
    return SITE_TITLE; 
  }
  
  $page_active = ucfirst(PAGE_ACTIVE);

  return SITE_TITLE ." | $page_active";
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
  $file_path = LAYOUTS_PATH ."/templates/$name.php";

  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El directorio no existe";
}

function get_layout(){
  $pages = [
    "home" => LAYOUTS_PATH ."index.php",
    "tienda" => LAYOUTS_PATH ."tienda.php",
    "contacto" => LAYOUTS_PATH ."contacto.php",
    "categorias" => LAYOUTS_PATH ."categorias.php",
    "search" => LAYOUTS_PATH ."search.php",
    "carrito" => LAYOUTS_PATH ."carrito.php",
    "cuenta" => LAYOUTS_PATH ."cuenta.php",
    "admin" => LAYOUTS_PATH ."admin.php",
  ];
  $target = $_GET['page'];
  
  if( !isset($_GET['page']) || !$pages[$target] ){
    return include $pages['home'];
  }

  return include $pages[$target];
}

/**
 * Carga el header del sitio ubicado en la carpeta `layouts`
 */
function get_header(){
  $file_path = LAYOUTS_PATH ."/templates/header/header.php";
  return file_exists( $file_path ) 
  ? include $file_path
  : "¡Error! El fichero no existe";
}

/**
 * Carga el footer del sitio ubicado en la carpeta `layouts`
 */
function get_footer(){
  $file_path = LAYOUTS_PATH ."/templates/footer.php";
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
  $page_active = ucfirst(PAGE_ACTIVE);
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
    $active_class = $page_active === $key['title'] ? "Header__nav__link--active" : "";
    $links .= "<li class='Header__nav__item'><a class='Header__nav__link $active_class' href='$key[link]'>$key[title]</a></li>";
  }

  return "<ul class='Header__nav'>$links</ul>";
}

/**
 * Función general para redireccionar al usuario a las diferentes páginas del sitio
 * 
 * @param string $page_title Si no se especifica ninguna página, redirecciona al inicio
 * @param bool $back Si se define como true, redirecciona al usuario al sitio anterior
 */
function redirect( string $page_title = "", bool $back = false ){

  if ( $back === true ){
    header("Location: ".$_SERVER['HTTP_REFERER']);
    return;
  }

  $pages = [
    'store' => STORE,
    'contact' => CONTACT,
    'account' => ACCOUNT,
    'login' => ACCOUNT ."login/"
  ];

  $target = $pages[$page_title] ? $pages[$page_title] : SITE_URL;

  header("Location: $target");
  return;
}

/**
 * Recupera el valor de `$_SESSION['msg']` e imprime una alerta con el contenido
 */
function get_msg(){
  session_start();
  if(isset($_SESSION['msg'])){

    $type = $_SESSION['msg']['type'];
    $msg = $_SESSION['msg']['content'];
    $output = "
      <section class='Form__notices Form__notices--$type'>
        <p>$msg</p>
      </section> ";
    unset($_SESSION['msg']);

    return $output;
  } 
}

#######################################
#                                     #
# Functiones de la tienda             #
#                                     #
#######################################

/**
 * Añade productos o actualiza el carrito de compras
 * 
 * Si el id del `$item` no existe en el carrito, lo añade, si el id del `$item` ya existe en el carrito comprueba si `$update` es `true`, de ser así, `actualizará` la cantidad de unidades, si no, `Añadirá` nuevas unidades
 * 
 * @param array $cart Array del carrito de compras
 * @param array $item Información del producto que se añadirá
 * @param bool $update Define true si se actualizará las unidades de un producto
 * 
 * @return mixed Carrito de compras actualizado
 */
function update_cart( array $cart, array $item, bool $update = false ){

  $id = $item['id'];
  $units = $item['units'];
  $name = $item['name'];
  $img = $item['img'];
  $price = $item['price'];
  $max = $item['max'];

  // Finaliza si uno de los dos parámetros está vacío
  if( empty($id) || empty($units) ){ return null; }

  foreach ($cart as $key => $product) {
    // Si el producto ya existe en el carrito
    if ( $product['id'] === $id ){
      // Para actualizar unidades
      if( $update === true ){
        $new_quantity = $units;
      // Para añadir unidades
      } else {
        $new_quantity = $cart[$key]['units'] + $units;
      }

      $cart[$key]['units'] = $new_quantity >= $max ? $max : $new_quantity; 

      return $cart;
    }
  }
  
  $cart[] = array( 
    "id" => $id, 
    "units" => $units,
    "name" => $name,
    "img" => $img,
    "price" => $price,
    "max" => $max
  );

  return $cart;
}

/**
 * Elimina un producto del carrito de compras
 * 
 * @param array $cart Array del carrito de compras
 * @param array $id Id del producto que se eliminará del carrito de compras
 * 
 * @return mixed Carrito de compras actualizado
 */
function remove_cart_item( array $cart, int $id ){

  foreach ($cart as $key => $product) {
    // Elimina del carrito el producto que coincida con el id especificado
    if ( $product['id'] == $id ){
      unset($cart[$key]);
      return $cart;
    }
  }

  return $cart;
}

/**
 * Obtiene la cantidad de productos añadidos al carrito
 * 
 * @return mixed Devuelve `empty` si el carrito está vacío, o un entero si se encuentran productos
 */
function get_cart_units(){
  session_start();
  if( isset($_SESSION['cart']) ){
    return count($_SESSION['cart']) != 0 ? count($_SESSION['cart']) : 'empty';
  }
  return 'empty';
}

/**
 * Devuelve una cadena html con los items añadidos al carrito
 * 
 * @return string
 */
function get_cart_items(){
  session_start();

  $cart = $_SESSION['cart'];
  $target = SITE_URL ."inc/cart.php";
  $output = "";

  if( !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){ 
    return "<section class='flex'><h1 style='text-align: center'>Aún no has agregado productos a tu carrito.</h1></section>"; 
  }
  
  foreach ($cart as $product) {
    $id = $product['id'];
    $name = $product['name'];
    $price = $product['price'];
    $units = $product['units'];
    $max_units = $product['max'];
    $img = $product['img'];

    $output .= "
      <div class='Cart-item'>
        <div class='Cart-item__section'>
          <img src='$img' alt='$name' class='Cart-item__img'>
          <div class='Cart-item__info'>
            <h2 class='Cart-item__title'>$name</h2>
            <p class='Cart-item__price'>$$price x <strong class='Cart-item__units'>$units</strong></h2>
          </div>
        </div>
        <div class='Cart-item__section'>
          <form class='Cart' method='POST' action='$target'>
            <input type='hidden' name='id' value='$id'>
            <input type='hidden' name='units' value='$units'>
            <input type='hidden' name='max' value='$max_units'>
            <div class='Qty'>
              <span class='Qty__display'>$units</span>
              <span class='Qty__buttons'>
                <span class='Qty__button Qty__button--add'> + </span>
                <span class='Qty__button Qty__button--remove'> - </span>
              </span>
            </div>
            <input class='Cart__add Button' type='submit' name='updateCart' value='Actualizar'>
          </form>
          <a class='Cart-item__remove' href='$target?id=$id'><i class='Icon fa-solid fa-trash'></i></a>
        </div>
      </div>
    ";
  }

  return $output;
}

/**
 * Devuelve una cadena html con un resumen del total a pagar
 * 
 * @return string
 */
function get_cart_totals(){
  session_start();

  $cart = $_SESSION['cart'];
  $items = "";
  $final_total = 0;

  if( !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){ return ""; }
  
  foreach ($cart as $product) {
    $name = $product['name'];
    $price = $product['price'];
    $units = $product['units'];
    $total = $price * $units;

    $final_total += $total;
    $items .= "
      <li class='Totals__item'>
        <span class='Totals__name'>$name x $units</span>
        <span class='Totals__price'>$$total</span>
      </li>
    ";
  }

  $output = "    
    <ul class='Totals__list'>
      $items
    </ul>
    <div class='Totals__section'>
      <h2 class='Totals__value'>Total: $$final_total</h2>
      <a class='Button Totals__buy'>Comprar</a>
    </div>
  ";

  return $output;
}

#######################################
#                                     #
# Para obtener elementos generales    #
#                                     #
#######################################

/**
 * Devuelve un arreglo con la información de los productos consultados
 * 
 * @param int $category_id Especifica el id de una categoría para filtrar los productos
 * @param int $pet_id Especifica el id de una mascota para filtrar los productos
 * @return mixed
 */
function get_products( int $category_id = 0, int $pet_id = 0 ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  if( isset($_GET['search']) ){

    $query = "SELECT * FROM `products` WHERE name LIKE :search";
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':search', "%$_GET[search]%" );
    
  } else {
    if( $category_id !== 0 && $pet_id !== 0 ){
      // Si se especificó una categoría y una mascota
  
      $query = "SELECT * FROM `products` WHERE category = :category_id AND pet = :pet_id";
      $consult = $pdo->prepare( $query );
      $consult->bindValue( ':category_id', $category_id );
      $consult->bindValue( ':pet_id', $pet_id );
  
    }elseif( $category_id !== 0 || $pet_id !== 0 ){
      // Si se especificó una categoría o una mascota
  
      if ( $category_id !== 0 ){
        $where = 'category';
        $param = $category_id;
      } else {
        $where = 'pet';
        $param = $pet_id;
      }
  
      $query = "SELECT * FROM `products` WHERE $where = :query_param";
      $consult = $pdo->prepare( $query );
      $consult->bindValue( ':query_param', $param );
  
    } else {
      // Si no se especificó ningún parámetro
      $query = 'SELECT * FROM `products`';
      $consult = $pdo->prepare( $query );
    }  
  }
  
  $consult->execute();
  $result = $consult->fetchAll();
  
  $pdo = null;
  $consult = null;

  return $result;
}

/**
 * Devuelve un arreglo con toda la información del meta seleccionado
 * 
 * @param string $meta Especifica `pets` or `categories` para obtener la información respectiva
 * @return mixed
 */
function get_meta( string $meta ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  // Si no se especifica el meta a obtener
  if( empty($meta) ){
    return;
  }
  
  $tables = [
    'categories' => 'categories',
    'pets' => 'pets',
  ];
  
  if( !$tables[$meta] ){
    return;
  }
  
  $query = "SELECT * FROM `$tables[$meta]`";
  $consult = $pdo->prepare( $query );
  $consult->execute();
  $result = $consult->fetchAll();
  
  $pdo = null;
  $consult = null;

  return $result;
}

#######################################

#######################################
#                                     #
# Para obtener un elemento específico #
#                                     #
#######################################

/**
 * Obtiene un array la información de un producto específico
 * 
 * @param int $product_id Id del producto a consultar
 * @return mixed
 */
function get_product( int $product_id ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  # Si no se especifica el id de un producto
  if ( !$product_id ){ 
    return false; 
  }

  $query = 'SELECT * FROM `products` WHERE id = :product_id';
  $consult = $pdo->prepare( $query );
  $consult->bindValue( ':product_id', $product_id );

  $consult->execute();
  $result = $consult->fetch();
  
  $pdo = null;
  $consult = null;

  return $result;
}

/**
 * Obtiene un array con la información de una categoría
 * 
 * @param mixed $category Especifica el `id` o el `slug` de la categoría a consultar
 * @return mixed
 */
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

/**
 * Obtiene un array con la información de una mascota
 * 
 * @param mixed $pet Especifica el `id` o el `slug` de la mascota a consultar
 * @return mixed
 */
function get_pet( mixed $pet ){
  $pdo = db_connect();
  
  if (gettype( $pdo ) !== 'object'){
    print_r($pdo);
    return;
  }

  # Si no se especifica ni un id ni un slug
  if ( !$pet || empty($pet) ){ 
    return false; 
  }
  
  if ( gettype($pet) === 'integer' && $pet !== 0 ){
    $query = 'SELECT * FROM `pets` WHERE id = :pet_id';
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':pet_id', $pet );
    
  } else {
    $query = 'SELECT * FROM `pets` WHERE slug = :pet_slug';
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ':pet_slug', $pet );
  }
  
  $consult->execute();
  $result = $consult->fetch();
  
  $pdo = null;
  $consult = null;

  return $result;
}

/**
 * Devuelve un string con la url a donde apunta el botón de `get_filter()`
 * Comprueba si el usuario debe ser redirigido a `categorias/categoria` o `tienda/mascota/categoria` 
 * 
 * @param string $slug slug de la categoría o mascota
 * @return string
 */
function get_filter_url( string $slug ){
  $pet = $_GET['pet'];
  $category = $_GET['category'];
  $url = "";

  if ( (isset($pet) && isset($category)) || (isset($pet) && !isset($category)) ){
    $url = STORE ."$pet/$slug/";
  } else{
    $url = CATEGORIES ."$slug/";
  }
  
  return $url;
}

/**
 * Devuelve una candena html con un botón que hace de filtro para redirigir a una categoría o mascota
 * 
 * @param array $data Item del array obtenido con la función `get_meta()`
 */
function get_filter( array $data ){

  $name = $data['name'];
  $icon = $data['icon'] ? "<i class='Icon $data[icon]'></i>" : "<i class='Icon fa-solid fa-dog'></i>";
  $url = $data['url'] ? $data['url'] : get_filter_url( $data['slug'] );

  $output = "<a href='$url' class='Button Button--$name'> $icon $name </a>";
  
  return $output;
}

#######################################

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

    $target = SITE_URL ."inc/cart.php";

    $pet_icon = $icon_classes['Mascota'][$pet['name']];
    $category_icon = $icon_classes['Categoria'][$category['name']];
    $availability = $units > 0 
    ? "Disponible ($units)"
    : "Agotado";

    $output .= "
      <div class='Card Card--$category[name]'>
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
            <span class='Card__info__item Card__info__item--pet'>
              <i class='Icon fa-solid $pet_icon'></i>
              <p class=''>Para: $pet[name]</p>
            </span>
            <span class='Card__info__item Card__info__item--category'>
              <i class='Icon fa-solid $category_icon'></i>
              <p class=''>Categoría: $category[name]</p>
            </span>
            <span class='Card__info__item Card__info__item--Content'>
              <i class='Icon fa-solid fa-content'></i>
              <p class=''>Contenido: $content</p>
            </span>
          </div>
          <form class='Cart' method='POST' action='$target'>
            <input type='hidden' name='id' value='$id'>
            <input type='hidden' name='units' value='0'>
            <input type='hidden' name='name' value='$name'>
            <input type='hidden' name='img' value='$img'>
            <input type='hidden' name='price' value='$price'>
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

  return "<section class='products'>$output</section>";
}

#######################################

#######################################
#                                     #
# Funciones referentes al usuario     #
#                                     #
#######################################

/**
 * Valida la información recibida, crea un usuario y ejecuta `login_user()`
 * 
 * @param array $form Formulario de registro
 * @return mixed Devuelve un `string` con un mensaje si hubo algún error, sino, devuelve true
 */
function create_user( array $form ){

  $first_name = trim($form['first_name']);
  $last_name = trim($form['last_name']);
  $email = trim($form['email']);
  $password = trim($form['password']);
  $val_password = trim($form['val_password']);
  $role = "customer";
  
  # Valida si los campos está vacíos
  if( empty($first_name) || empty($email) || empty($password)  || empty($val_password) ){
    return "Debes rellenar todos los campos obligatorios.";
  }
  
  # Valida si el correo es válido
  if( strpos($email, "@") === false || strpos($email, ".com") == false ){
    return "Debes ingresar un email válido.";
  }
  
  # Valida si ambas contraseñas coinciden
  if( $password !== $val_password ){
    return "Las contraseñas no coinciden.";
  }

  # Valida si la contraseña tiene una longitud válida
  if( strlen( $password ) <= 7 ){
    return "Utiliza una contraseña más larga.";
  }

  # Valida si la contraseña incluye los carácteres requeridos
  if( preg_match( "([A-Z])", $password ) !== 1 || preg_match( "([0-9])", $password ) !== 1 || preg_match( "([-_#!¿?.,])", $password ) !== 1 ){
    return "Tu contraseña debe incluir mayúsculas, números y carácteres especiales.";
  }

  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    return print_r($pdo);
  }

  $query = "SELECT email FROM `users` WHERE email = :user_email";
  $consult = $pdo->prepare( $query );
  $consult->bindValue( ':user_email', $email );
  $consult->execute();
  $result = $consult->fetch();
  
  # Valida si el correo electrónico ya ha sido registrado
  if( !empty($result['email']) ){
    $pdo = null;
    $consult = null;
    return "Este correo ya se encuentra en uso.";
  }

  $query = "INSERT INTO `users` (first_name, last_name, email, password, role) VALUES (:first_name, :last_name, :email, :password, :role)";
  $consult = $pdo->prepare( $query );
  $binded_params = array(
    ":first_name" => $first_name, 
    ":last_name" => $last_name,
    ":email" => $email,
    ":password" => $password,
    ":role" => $role
  );
  
  try {
    $consult->execute( $binded_params );
    login_user( $first_name, $role );
    return true;

  } catch (\Throwable $th) {
    return "Vaya, parece que algo ha salido mal :(";
  }
}

/**
 * Valida la información recibida y ejecuta `login_user()`
 * 
 * @param array $form Formulario para iniciar sesión
 * @return mixed Devuelve un `string` con un mensaje si hubo algún error, sino, devuelve true
 */
function validate_user( array $form ){
  $email = $form['email'];
  $password = $form['password'];

  # Valida si los campos está vacíos
  if( empty($email) || empty($password) ){
    return "Debes rellenar todos los campos obligatorios.";
  }
  
  # Valida si el correo es válido
  if( strpos($email, "@") === false || strpos($email, ".com") == false ){
    return "Debes ingresar un email válido.";
  }

  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    return print_r($pdo);
  }

  $query = "SELECT first_name, email, password, role FROM `users` WHERE email = :user_email AND password = :user_password";
  $consult = $pdo->prepare( $query );
  $bind_params = array( 
    ':user_email' =>  $email,
    ':user_password' =>  $password
   );

  $consult->execute( $bind_params );
  $result = $consult->fetch();

  $pdo = null;
  $consult = null;
  
  # Valida si el usuario ya se encuentra registrado
  if( empty($result['email']) && empty($result['password']) ){
    return "El correo o la contraseña no coinciden";
  }

  login_user( $result['first_name'], $result['role'] );
  return true;
}

/**
 * Inicia sesión con la información del usuario
 * 
 * @param string $name Nombre del usuario
 * @param string $role Rol del usuario
 */
function login_user( string $name, string $role ){
  session_start();
  $_SESSION['user'] = array('name' => $name, 'role' => $role);
  redirect("account");
}

/**
 * Devuelve `true` si el usuario ha iniciado sesión, delo contrario devuelve `false`
 */
function is_logedin(){
  session_start();
  return isset($_SESSION['user']) ? true : false;
}

/**
 * Devuelve `true` si el usuario posee el rol de `admin`, delo contrario devuelve `false`
 */
function is_admin(){
  session_start();
  $user = $_SESSION['user'];

  if( !isset($user) ){
    return false;
  }

  return $user['role'] === 'admin' ? true : false;
}

/**
 * Cierra la sesión actual del usuario
 */
function logout_user(){
  session_start();
  unset($_SESSION['user']);
  redirect();
}

#######################################

#######################################
#                                     #
# Funciones de la administración      #
#                                     #
#######################################

function admin_products(){
  
  $products = get_products();
  $items = "";

  foreach ($products as $product) {
    $id = $product['id'];
    $img =  IMG_URI ."placeholder.png";
    $name = $product['name'];
    $price = $product['price'];
    $units = $product['units'];
    $content = $product['content'];
    $pet = get_pet( $product['pet'] )['name'];
    $category = get_category($product['category'])['name'];
    $edit = SITE_URL ."inc/products.php";
    $delete = SITE_URL ."inc/products.php?action=delete&id=$id";

    $items .= "
      <tr>
        <td>$id</td>
        <td><img src='$img' alt='$name'></td>
        <td>$name</td>
        <td>$price</td>
        <td>$units</td>
        <td>$content</td>
        <td>$pet</td>
        <td>$category</td>
        <td>
          <i id='$id' class='fa-solid fa-pen'></i>
          <a href='$delete'><i class='fa-solid fa-trash'></i></a>
        </td>
      </tr>
    ";

  }
  
  $output = "  
    <table class='Table Table--products'>
      <thead>
        <tr>
          <th>Id</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Unidades</th>
          <th>Contenido</th>
          <th>Mascota</th>
          <th>Categoría</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        $items
      </tbody>
    </table>
  ";

  return $output;
}

function create_product( array $product ){
  # print_r( $product );

  $name = trim($product['name']);
  $price = $product['price'];
  $content = trim($product['content']);
  $units = $product['units'];
  $pet = (int)$product['pet'];
  $category = (int)$product['category'];
  $img_directory = "../src/img/products/";

  # $image = isset($product['image']) ? trim($product['image']) : 'placeholder.png';
  
  if ( empty($name) || empty($price) || empty($units) || empty($pet) || empty($category) ){
    return "Debes rellenar todos los campos obligatorios.";
  }

  if( get_pet( $pet ) === false ){
    return "Aún no admitimos este tipo de mascota, intenta añadirla a la lista.";
  }
  
  if( get_category( $category ) === false ){
    return "Aún no contamos con esta categoría, intenta añadirla a la lista.";
  }

  if( !file_exists( $img_directory ) ){
    mkdir( $img_directory, 0777, true );
  }

  print_r( $_FILES );


  




  return false;
}

function delete_product( int $id ){
  $pdo = db_connect();

  if (gettype( $pdo ) !== 'object'){
    return print_r($pdo);
  }

  $query = 'SELECT id FROM `products` WHERE id = :id_product';
  $consult = $pdo->prepare( $query );
  $consult->bindValue( ":id_product", $id );
  $consult->execute();
  $result = $consult->fetch();

  if( !empty($result) ){
    $query = "DELETE FROM `products` WHERE id = :id_product";
    $consult = $pdo->prepare( $query );
    $consult->bindValue( ":id_product", $id );
    $consult->execute();
  }
  
  $pdo = null;
  $result = null;
  return;

}