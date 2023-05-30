<?php

$category = 0;
$products = get_products($category); ?>

<div class="Store">

  <?php if (empty($products)): ?>

    <section class="flex">
      <h1> Parece que aún no hay productos agregados</h1>
    </section>

  <?php else: ?>

    <section class="products">

      <?php echo the_products( $products ); ?>

    </section>
    
  <?php endif; ?>
</div>