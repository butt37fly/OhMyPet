<section class="Form-container">
  <div class="Form-container__header">
    <h2>Crear cuenta</h2>
    <h5>¿Ya tienes una? haz click <a href="<?php echo ACCOUNT ."login/"?>">aquí</a> para iniciar sesión.</h5>
  </div>
  <form class="Form" method="POST" action="<?php echo SITE_URL ."inc/user.php"?>">
    <div class="Form__section">
      <div class="Form__field">
        <label for="first_name">¿Cuál es tu primer nombre?</label>
        <input class="Form__input" id="first_name" type="text" name="first_name" placeholder="Pepito" required> 
      </div>
      <div class="Form__field">
        <label for="last_name">¿Cuál es tu apellido?</label>
        <input class="Form__input" id="last_name" type="text" name="last_name" placeholder="Pérez"> 
      </div>
    </div>
    <div class="Form__section">
      <div class="Form__field">
        <label for="email">¿Cuál es tu dirección de correo electrónico?</label>
        <input class="Form__input" id="email" type="email" name="email" placeholder="pepitoperez123@example.com" required> 
      </div>
    </div>
    <div class="Form__section">
      <div class="Form__field">
        <label for="password">Crea una contraseña segura</label>
        <input class="Form__input" id="password" type="password" name="password" placeholder="" required> 
      </div>
      <div class="Form__field">
        <label for="val_password">Verifica tu contraseña</label>
        <input class="Form__input" id="val_password" type="password" name="val_password" placeholder="" required> 
      </div>
    </div>
    <div class="Form__section">
      <div class="Form__field Form__field--tips">
        <ul class="Form__tips">
          <li class="Form__tips__items">
            <i class="fa-sharp fa-solid fa-check-circle"></i>
            <p>Las contraseñas coinciden.</p>
          </li>
          <li class="Form__tips__items">
            <i class="fa-sharp fa-solid fa-check-circle"></i>
            <p>Tu contraseña tiene 8 carácteres o más.</p>
          </li>
          <li class="Form__tips__items">
            <i class="fa-sharp fa-solid fa-check-circle"></i>
            <p>Utiliza letras, números y carácteres especiales.</p>
          </li>
        </ul>
      </div>
    </div>
    <div class="Form__section">
      <input class="Button" type="submit" name="createUser" value="Continuar"/>
    </div>
  </form>
  <?php echo get_msg(); ?>
</section>