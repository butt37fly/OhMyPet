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
    
    <section class="Header__section Header__section--right">
      <form id="search-form">
        <div class="Form__field">
          <i class="Icon fa-solid fa-search"></i>
          <input class="Form__input" type="text" name="search" placeholder="Busca lo que necesites">
        </div>
      </form>
      
      <a href="<?php echo ACCOUNT; ?>">
        <i class="Icon fa-solid fa-user"></i>
      </a>
      <a href="<?php echo CART; ?>">
        <i class="Icon Icon--cart fa-solid fa-cart-shopping" data-cart-units="<?php echo get_cart_units();?>"></i>
      </a>
    </section>
  
  </nav>

</header>