<section class="Filters">
  <section class="Filters__section Filters__section--pets">

    <?php

    #fa-solid fa-dog
    $pets = get_meta('pets');
    $filters = "";

    foreach ($pets as $pet) {
      $filters .= get_filter($pet);
    }

    echo $filters; ?>

  </section>
  <section class="Filters__section Filters__section--categories">
    <?php

    $categories = get_meta('categories');
    $filters = "";

    foreach ($categories as $category) {
      $filters .= get_filter($category);
    }

    echo $filters; ?>

  </section>
</section>