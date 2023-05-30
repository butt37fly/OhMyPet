<section class="Banner flex h-full w-full">
  <div class="Banner__section flex">
    <h1 class="Banner__title">¡Encuentra lo mejor, para <strong>el mejor</strong>!</h1>
  </div>
  <div class="Banner__section flex">
    <img src="" alt="">
  </div>
</section>
<section class="Featured flex flex--column mb-5">
  <h2 class="Featured__title mb-3"> Productos para <strong>Perros</strong></h2>
  <div class="Featured__wrapper p-5">

    <?php $products = get_products( 0, 1 ); echo the_products($products); ?>

  </div>
</section>
<section class="Featured flex flex--column mb-5">
  <h2 class="Featured__title mb-3"> Productos para <strong>Gatos</strong></h2>
  <div class="Featured__wrapper p-5">

    <?php $products = get_products( 0, 2 ); echo the_products($products); ?>

  </div>
</section>