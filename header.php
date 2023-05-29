<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo get_title()?></title>
  <!-- Estilos -->
  <link rel="stylesheet" href="<?php echo get_script("main", "css")?>">
  <!-- Scripts -->
  <script type="text/javascript" src="<?php echo get_script("main", "js")?>" defer></script>
  <!-- FontAwesome -->
  <link rel="preconnect" href="https://kit.fontawesome.com" />
  <script src="https://kit.fontawesome.com/90787c1f40.js" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header Desktop -->
  
  <?php get_template( 'header/header-desktop' )?>

  <!-- Header Mobile -->
  
  <?php get_template( 'header/header-mobile' )?>

  <!-- Efecto Overlay -->

  <section class="Overlay"></section>
  
  <!-- Site content -->