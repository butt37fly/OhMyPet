<?php

$pet = 0;
$category = 0;

if (isset($_GET['pet'])) {
  $pet = get_pet($_GET['pet'])['id'];
}

if (isset($_GET['category'])) {
  $category = get_category($_GET['category'])['id'];
}

$products = get_products($category, $pet); ?>

<div class="Store">

  <?php get_template('filters'); ?>

  <?php if(empty($products)): ?>

    <section class="flex">
      <h1> Aún no tenemos productos en esta categoría :(</h1>
    </section>

  <?php else: ?>

    <?php echo the_products($products); ?>

  <?php endif; ?>
</div>