<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo get_title()?></title>
  <!-- Styles -->
  <link rel="stylesheet" href="<?php echo get_script("main", "css")?>">
  <link rel="stylesheet" href="<?php echo get_script("classes.min", "css")?>">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo get_script("FontAwesome/fontawesome.min", "css")?>">
  <link rel="stylesheet" href="<?php echo get_script("FontAwesome/solid.min", "css")?>">
  <!-- Scripts -->
  <script type="text/javascript" src="<?php echo get_script("main", "js")?>" defer></script>
</head>
<body>

  <!-- Header Desktop -->
  
  <?php get_template( 'header/header-desktop' )?>

  <!-- Header Mobile -->
  
  <?php get_template( 'header/header-mobile' )?>

  <!-- Efecto Overlay -->

  <section class="Overlay"></section>
  
  <!-- Site content -->