<?php include "../app/includes/header.php"; ?>
<?php include "../app/includes/addToBag.php"; ?>
<?php include "../app/filters/favorite.php"; ?>

<!-- SIMILAR ITEMS -->
<?php if(!empty($results[0])) { ?>
  <div id="vertical-spacing"></div>
  <div id="item-body-content" class="cirlces-background">
    <div id="similar-items" >
       <h1 id="favorite">Favorites</h1>
       <div class="under-bar"></div>
     </div>
      <section id="item-list" class="container">
        <div class="item-holder item-margin-top">
          <?php for ($i=0; $i < sizeof($results) ; $i++) { ?>
          <div class="item">
            <a href="item.php?item=<?php echo $results[$i]->id ?>">
              <img src="img/<?php echo $results[$i]->item_main_img; ?>" alt="">
            </a>
            <div class="item-menu">
              <div>
                <i class="fas <?php
                  $class = CheckCartItems($AllitemInCart, $results[$i]->id);
                  echo $class;
                 ?>" id="<?php echo $results[$i]->id; ?>"></i>
              </div>
              <div><i class='fas fa-heart' id="<?php echo $results[$i]->id; ?>"></i></div>
            </div>
            <h3 class="item-name"><?php echo $results[$i]->item_name ?></h3>
            <h4 class="price"><?php echo $results[$i]->item_price ?>€</h4>
          </div>
          <?php }?>
        </div>
      </section>
    <?php } elseif(isset($_SESSION['name']) && empty($results[0])){
      echo
      "<div id='empty-favorite'>
         <h4>You have no favorite items</h4>
       </div>
      ";
    }else{
      header('Location: login.php');
    } ?>
    </div>

    <div id="vertical-spacing"></div>

    <?php include "../app/includes/footer.php"?>
    </div>
  </div>
</body>
<script src="js/item.js"></script>
<script src="js/addToBag.js"></script>
<script src="js/headerNav.js"></script>
<script src="js/footerNav.js"></script>
<script src="js/mediaQueries.js"></script>
</html>
