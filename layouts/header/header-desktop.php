<header class="Header">
  
  <nav class="Header__wrapper">

    <section class="Header__section">
      <a class="Header__logo" href="<?php echo HOME; ?>">
        <img class="Header__logo__img" src="<?php echo SITE_LOGO; ?>" alt="OhMyPet" />
      </a>
    </section>

    <section class="Header__section">
      <?php echo get_page_nav(); ?>
    </section>
    
    <section class="Header__section">
      <form>
        <input type="text">
      </form>

      <a href="<?php echo ACCOUNT; ?>">
        <i class="Icon fa-solid fa-user"></i>
      </a>
      <a href="<?php echo CART; ?>">
        <i class="Icon fa-solid fa-cart-shopping"></i>
      </a>
    </section>
  
  </nav>

</header>