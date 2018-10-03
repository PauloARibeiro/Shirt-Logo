<?php include "../app/includes/header.php"; ?>
<?php include "../app/auth/login.php"; ?>
    <!-- BODY -->
    <!-- ITEM CONTENT -->
    <div id="body-content" >
      <div id="vertical-spacing"></div>
      <div id="user-validation" class="shadow">
        <div id="user-header">
          <h3 class="user-selected"><a href="login.php">Sign In</a></h3>
          <h3><a href="register.php">Register</a></h3>
        </div>

        <form action="login.php" class="container" id="log-in-form" method="POST">
          <h6 id="error"><?php echo $error; ?></h6>
          <input type="email" placeholder="Email" class="email-form" name="email">
          <input type="password" placeholder="Password" class="password-form" name="password">
          <a href="" id="forgot-password">Forgot your password?</a>
        </form>

        <input class="btn btn-purple" type="submit" form="log-in-form" value="Log in" id="login">
      </div>
    </div>
    <div id="vertical-spacing"></div>
  </body>
  <!-- <script src="js/userValidation.js"></script> -->
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</html>
