<?php 

require_once "database.php";
require_once "functions.php";

define('SITE_TITLE' , 'OhMyPet' );
define('SITE_URL' , 'http://localhost/OhMyPet/' );

define('MAX_UPLOAD_SIZE' , 20000 );

define('ROOT_PATH', getcwd() .'/' );
define('LAYOUTS_PATH', ROOT_PATH .'layouts/' );

# Rutas del contenido
define('CSS_URI', SITE_URL .'src/css/' );
define('JS_URI', SITE_URL .'src/js/' );
define('IMG_URI', SITE_URL .'src/img/' );

# Sitios
define('HOME', SITE_URL );
define('STORE', SITE_URL .'tienda/' );
define('CONTACT', SITE_URL .'contacto/' );
define('CATEGORIES', SITE_URL .'categorias/' );
define('SEARCH', SITE_URL .'search/' );
define('CART', SITE_URL .'carrito/' );
define('ACCOUNT', SITE_URL .'cuenta/' );
define('ADMIN', SITE_URL .'admin/' );

define('SITE_LOGO' , IMG_URI .'logo.png' );