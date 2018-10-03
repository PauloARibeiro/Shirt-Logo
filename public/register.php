<?php include "../app/includes/header.php"; ?>
<?php include "../app/auth/register.php"; ?>

    <!-- BODY -->
    <!-- ITEM CONTENT -->
    <div id="body-content" >
      <div id="vertical-spacing"></div>
      <div id="user-validation" class="shadow">
        <div id="user-header">
          <h3><a href="login.php">Sign In</a></h3>
          <h3 class="user-selected"><a href="register.php">Register</a></h3>
        </div>

        <form action="register.php" class="container" id="register-form" method="POST">
          <h6 id="error"><?php echo $error; ?></h6>
          <input type="text" name="first_name" value="" placeholder="First name">
          <input type="text" name="last_name" value="" placeholder="Last name">
          <input type="email" placeholder="Email" class="email-form" name="email">
          <input type="password" placeholder="Password" class="password-form" name="password">
          <input type="password" placeholder="Confirm Password" class="password-confirm-form" name="confirm_password">
        </form>

        <input class="btn btn-purple" type="submit" form="register-form" value="Register" id="register">
      </div>
    </div>
    <div id="vertical-spacing"></div>
  </body>
  <!-- <script src="js/userValidation.js"></script> -->
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</html>
