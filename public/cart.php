<?php include "../app/includes/header.php"; ?>
<?php include "../app/cart.php"; ?>
<?php include "../app/includes/addToBag.php"; ?>
<?php include "../app/includes/itemEdit.php";?>

  <!-- body -->
    <!-- BODY -->
    <div id="vertical-spacing"></div>
    <!-- ITEM CONTENT -->
    <div id="body-content">
      <div id="cart-list" class="container">
        <?php if(!empty($results)){ $total = 0;?>
        <?php for ($i=0; $i < sizeof($results); $i++) {?>
          <div id="cart-item">
            <input type="checkbox" checked>
            <div>
              <a href="item.php?item=<?php echo $results[$i]->id ?>"><img src="img/<?php echo $results[$i]->item_main_img?>" alt=""></a>
            </div>
            <div id ="cart-item-info">
              <h4><a href="item.php?item=<?php echo $results[$i]->id ?>"><?php echo $results[$i]->item_name?></a></h4>
              <h5>Color:
                <span>
                  <?php echo ucfirst($results[$i]->color); ?>
                </span>
              </h5>
              <h5 class="cart-info-size">Size:
               <span>
                 <?php
                 if(empty($cart) || $cart[$i]->selected_size == "empty"){
                   echo "S";
                 }else{
                   echo $cart[$i]->selected_size; }
                 ?>
               </span>
              </h5>
            </div>
            <div>
              <input type="number" name="" value="1" min="1" id="amount" autocomplete="off">
            </div>
            <div>
              <h5 ><span class="cart-price"><?php echo $results[$i]->item_price?></span> €</h5>
            </div>
            <div>
              <a href="cart.php?edit=<?php echo $results[$i]->id ?>"><i class="fas fa-pencil-alt" id="<?php echo $results[$i]->id ?>"></i></a>
              <i class="fas fa-times" id="<?php echo $results[$i]->id ?>"></i>
            </div>
          </div>
          <?php $total += $results[$i]->item_price; ?>
        <?php }} ?>
      </div>

      <div id="checkout" class="container">
        <hr>
        <h4>Total: <span><?php echo $total ?></span>€</h4>
        <a href="" class="btn btn-purple">Checkout</a>
      </div>

      <div id="vertical-spacing"></div>

      <?php if(!empty($similarItems)){ ?>
      <!-- SIMILAR ITEMS -->
      <div id="similar-items" class="cirlces-background">
        <h1>Popular items</h1>
        <div class="under-bar"></div>

        <section id="item-list" class="container">
          <div class="item-holder item-margin-top">
            <?php for ($i=0; $i < sizeof($similarItems) ; $i++) {?>
            <div class="item">
              <a href="item.php?item=<?php echo $similarItems[$i]->id ?>">
                <img src="img/<?php echo $similarItems[$i]->item_main_img; ?>" alt="" class="similar-img">
              </a>
              <div class="item-menu">
                <div>
                  <i class="fas <?php
                  $class = CheckCartItems($AllitemInCart, $similarItems[$i]->id);
                  echo $class;
                   ?>" id="<?php echo $similarItems[$i]->id ?>"></i>
                </div>
                <div>
                  <?php
                    if(isset($_SESSION['name'])){
                      echo CheckFavoriteItem($similarItems, $i, $isItemFavorite);
                    }else{
                      echo "<a href='login.php'><i class='far fa-heart' id='{$similarItems[$i]->id}'></i></a>";
                    }
                  ?>
                </div>
              </div>
              <h3 class="item-name"><?php echo $similarItems[$i]->item_name; ?></h3>
              <h4 class="price"><?php echo $similarItems[$i]->item_price; ?>€</h4>
            </div>
          <?php }}?>
        </section>

      </div>

      <div id="vertical-spacing"></div>

      <?php include "../app/includes/footer.php"?>
    </div>
  </body>
  <script src="js/item.js"></script>
  <script src="js/addToBag.js"></script>
  <script src="js/editItem.js"></script>
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</html>
