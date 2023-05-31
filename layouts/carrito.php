<section class="Cart-view flex">
  <div class="Cart-view__wrapper">
    
    <?php echo get_cart_items(); ?>

  </div>
  <aside class="Cart-view__totals">

  <?php get_cart_totals();?>

  </aside>
</section>