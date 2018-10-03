<?php include "../app/includes/header.php"; ?>
<?php include "../app/dashboard.php"; ?>

<!-- SIMILAR ITEMS -->
<?php if(!empty($results)){ ?>
  <div id="item-body-content">
    <section id="dashboard-holder">
      <div id="dashboard-header" class="cirlces-background">
        <div id="vertical-spacing"></div>
        <div class="profile-img-holder shadow" >
          <input type="file" multiple accept='image/*' onchange="profileImgSelect.ImgChange()">
          <h3 class="">Change Photo</h3>
          <img src="<?php
            if($results[0]->user_picture != null){
              echo "img\user_picture/" .  $results[0]->user_picture;
            }else{
              echo  'img\user_picture\placeholder.jpg';
            };
          ?>" alt="">
        </div>
        <h6 id="error"></h6>
        <h5>Welcome back</h5>
        <h3><?php echo $_SESSION['name']?></h3>
      </div>
      <div id="dashboard-body" class="container">
        <a href="security.php">
          <div class="dashboard-content">
            <div class="">
              <i class="fas fa-lock fa-2x"></i>
              <p>Security</p>
            </div>
            <div class="">
              <p>Change/update your info.</p>
            </div>
          </div>
        </a>

        <a href="favorite.php">
          <div class="dashboard-content">
            <div class="">
              <i class="fas fa-star fa-2x"></i>
              <p>Favorites</p>
            </div>
            <div class="">
              <p>Check the items you favorited.</p>
            </div>
          </div>
        </a>

        <a href="cart.php">
          <div class="dashboard-content">
            <div class="">
              <i class="fas fa-shopping-cart fa-2x"></i>
              <p>Cart</p>
            </div>

            <div class="">
              <p>Check the items in your cart.</p>
            </div>
          </div>
        </a>
      </div>
    </section>
  </div>
<?php } else{
  header('Location: login.php');
}?>
    <div id="vertical-spacing"></div>

    <?php include "../app/includes/footer.php"?>
    </div>
  </div>
</body>
<script src="js/profileImgSelect.js"></script>
<script src="js/headerNav.js"></script>
<script src="js/footerNav.js"></script>
<script src="js/mediaQueries.js"></script>
</html>
