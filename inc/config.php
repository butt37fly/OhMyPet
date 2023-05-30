<?php 

require_once "database.php";
require_once "functions.php";

define('SITE_TITLE' , 'OhMyPet' );
define('SITE_URL' , 'http://localhost/OhMyPet/' );

define('ROOT_PATH', getcwd() .'/' );

define('LAYOUTS_PATH', ROOT_PATH .'layouts/' );
define('INC_PATH', ROOT_PATH .'inc/' );

# Rutas del contenido multimedia
define('CSS_URI', SITE_URL .'src/css/' );
define('JS_URI', SITE_URL .'src/js/' );
define('IMG_URI', SITE_URL .'src/img/' );

# Sitios
define('HOME', SITE_URL );
define('STORE', SITE_URL .'tienda/' );
define('CONTACT', SITE_URL .'contacto/' );
define('ACCOUNT', SITE_URL .'cuenta/' );
define('CART', SITE_URL .'carrito/' );

define('SITE_LOGO' , IMG_URI .'logo.png' );