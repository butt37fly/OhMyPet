<?php 

require "database.php";
require "functions.php";

define('SITE_TITLE' , 'OhMyPet' );
define('SITE_URL' , 'http://localhost/OhMyPet/' );

define('ROOT_PATH', getcwd() .'/' );

# Rutas para acceder desde fuera del directorio src
define('CSS_URI', SITE_URL .'src/css/' );
define('JS_URI', SITE_URL .'src/js/' );
