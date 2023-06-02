<section class="Admin-view">
  
  <?php echo admin_products(); ?>
  <?php echo get_msg(); ?>

  <section class="Modal" id="productsModal">
    <div class="Modal__overlay"></div>
    <div class="Modal__wrapper">
      <button class="Icon fa-solid fa-circle-xmark closeButton"></button>
      <section class="Form-container">
        <div class="Form-container__header">
          <h2>Añade un nuevo producto</h2>
        </div>
        <form class="Form" method="POST" action="<?php echo SITE_URL ."inc/products.php"?>" enctype="multipart/form-data">
          <div class="Form__section">
            <div class="Form__field">
              <label for="name">Nombre</label>
              <input class="Form__input" id="name" type="text" name="name" placeholder="Shampoo anti-pulgas" required> 
            </div>
            <div class="Form__field">
              <label for="image">Imagen</label>
              <input class="Form__input" id="image" type="file" name="image" accept="image/*"> 
            </div>
          </div>
          <div class="Form__section">
            <div class="Form__field">
              <label for="price">Precio</label>
              <input class="Form__input" id="price" type="number" name="price" placeholder="15000" required> 
            </div>
            <div class="Form__field">
              <label for="content">Contenido neto</label>
              <input class="Form__input" id="content" type="text" name="content" placeholder="250ml"> 
            </div>
            <div class="Form__field">
              <label for="units">Unidades disponibles</label>
              <input class="Form__input" id="units" type="number" name="units" placeholder="50" required> 
            </div>
          </div>
          <div class="Form__section">
            <div class="Form__field">
              <label for="pet">Mascota</label>
              <select class="Form__input" id="pet" name="pet" required> 
                
                <?php 
                  $pets = get_meta( 'pets' ); 
                  foreach ($pets as $pet){

                    echo "<option value='$pet[id]'>$pet[name]</option>";

                  } ?>
              
              </select>
            </div>
            <div class="Form__field">
              <label for="category">Categoría</label>
              <select class="Form__input" id="category" name="category" required> 

                <?php 
                  $categories = get_meta( 'categories' ); 
                  foreach ($categories as $category){

                    echo "<option value='$category[id]'>$category[name]</option>";

                  } ?>

              </select>
            </div>
          </div>
          <div class="Form__section">
            <input class="Button" type="submit" name="createProduct" value="Añadir producto"/>
          </div>
        </form>
      </section>
    </div>
  </section>
  <section class="Shortcut">
    <i class="Icon fa-solid fa-circle-plus" data-target="productsModal"></i>
  </section>
</section>