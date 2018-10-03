<?php include "../app/includes/header.php"; ?>
<?php include "../app/dashboard.php"; ?>
<?php include "../app/security.php"; ?>
<!-- SIMILAR ITEMS -->
<?php if(!empty($results)){ ?>
  <div id="item-body-content">
    <section id="dashboard-holder">
      <div id="dashboard-header" class="cirlces-background">
        <div id="vertical-spacing"></div>
        <div class="profile-img-holder shadow" >
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
          <!-- <h6 id="errorImg"></h6> -->
        </div>
        <h5>Welcome back</h5>
        <h3><?php echo $_SESSION['name']?></h3>
      </div>
      <h6 id="error"><?php echo $error?></h6>
      <div id="dashboard-body" class="container">
        <form class="" action="security.php" method="post">
          <label for="first_name">First name</label>
          <input type="text" name="first_name" value="<?php echo $results[0]->first_name ?>">

          <label for="last_name">Last name</label>
          <input type="text" name="last_name" value="<?php echo $results[0]->last_name ?>">

          <label for="email">Email</label>
          <input type="text" name="email" value="<?php echo $results[0]->email ?>">

          <label for="address">Address</label>
          <input type="text" name="address" value="<?php echo $results[0]->address ?>">

          <label for="country">Country</label>
          <select name="country" id="country_select" onchange="citySelection.ListStates(this.value)">
            <?php
              if($results[0]->country == ""){
                echo '<option value="">Select your country</option>';
              }else{
                echo '<option value="' . $results[0]->country . '">' . $results[0]->country . '</option>';
              }
            ?>
          </select>

          <label for="state">State</label>
          <select name="state" id="state_select" onchange="citySelection.ListCities(this.value)" <?php if($results[0]->state == ""){ echo "disabled";} ?>>
            <?php
              if($results[0]->state == ""){
                echo '<option value="">Select your state</option>';
              }else{
                echo '<option value="' . $results[0]->state . '">' . $results[0]->state . '</option>';
              }
            ?>
          </select>

          <label for="city">City</label>
          <select name="city" id="city_select" <?php if($results[0]->city == ""){ echo "disabled";} ?>>
            <?php
              if($results[0]->city == ""){
                echo '<option value="">Select your city</option>';
              }else{
                echo '<option value="' . $results[0]->city . '">' . $results[0]->city . '</option>';
              }
            ?>
          </select>

          <label for="postal_code">Postal Code</label>
          <input type="text" name="postal_code" value="<?php
            if($results[0]->postal_code == "0"){
              echo "";
            }else{
              echo ($results[0]->postal_code);
            }
           ?>">

          <label for="phone_number">Phone Number</label>
          <input type="text" name="phone_number" value="<?php
            if($results[0]->phone_number == "0"){
              echo "";
            }else{
              echo ($results[0]->phone_number);
            }
           ?>">
          <button type="submit" name="" value="Update" class="btn btn-purple">Update</button>
        </form>
      </div>
    </section>
  </div>
<?php }else{
  echo "<script>location='login.php'</script>";
}?>
    <div id="vertical-spacing"></div>

    <?php include "../app/includes/footer.php"?>
    </div>
  </div>
  <script src="js/profileImgSelect.js"></script>
  <script src="js/citySelector.js"></script>
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</body>
</html>
