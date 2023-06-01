<section class="Account">

  <?php

  $action = $_GET['action'];

  if ($action === "login") {

    if (is_logedin()) {
    
      redirect("account");
    
    }
    
    get_template('account/login');
    
  } elseif ($action === "signup") {
    
    if (is_logedin()) {

      redirect("account");
    
    }

    get_template('account/signup');

  } else {

    if (is_logedin()) {

      get_template('account/profile');

    } else {

      redirect("login");

    }
  } ?>

</section>