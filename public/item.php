<?php include "../app/includes/header.php"; ?>
<?php include "../app/includes/addToBag.php"; ?>
<?php include "../app/filters/item.php"; ?>

    <!-- BODY -->
    <div id="vertical-spacing"></div>
    <!-- ITEM CONTENT -->
    <div id="item-body-content" class="cirlces-background">
      <?php if(!empty($results[0])) { ?>
      <section id="product" class="container">
        <div id="product-img">
          <div>
            <img src="img/<?php echo $results[0]->item_main_img ?>" alt="" class="main-img ">
            <div id="side-imgs">
              <img src="img/<?php echo $results[0]->item_main_img ?>" alt="" class="sub-img active-product">
            </div>
          </div>
          <!-- <div>
            <img src="img/product-img.jpeg" alt="" class="sub-img active-product">
            <img src="img/product-img.jpeg" alt="" class="sub-img">
            <img src="img/product-img.jpeg" alt="" class="sub-img">
          </div> -->
        </div>
        <div id="product-info">
          <h3 id="product-title"><?php echo $results[0]->item_name ?></h3>
          <h4 id="product-price"><?php echo $results[0]->item_price . "€" ?></h4>
          <h6 id="product-color">Color: <span></span></h6>
          <div id="available-colors">
            <div class="square active <?php echo $results[0]->color; ?>"></div>
            <!-- <div class="square green "></div>
            <div class="square pink"></div> -->
          </div>
          <div id="available-size">
            <div class="size-box selected <?php if($results[0]->x_small == 0) {echo 'disabled';} ?>"><span>xs</span></div>
            <div class="size-box <?php if($results[0]->small == 0) {echo 'disabled';} ?>"><span>s</span></div>
            <div class="size-box <?php if($results[0]->medium == 0) {echo 'disabled';} ?>"><span>m</span></div>
            <div class="size-box <?php if($results[0]->large == 0) {echo 'disabled';} ?>"><span>l</span></div>
          </div>
          <div id="<?php echo $results[0]->item_id; ?>" class="
            <?php
            //if user is logged in
            if(empty($itemInCart)){
              echo 'btn btn-purple add-to-bag'; }
            elseif(!empty($itemInCart)){
              echo 'btn btn-disabled';
            }

            //if user is NOT logged in
            if(!isset($_SESSION['name'])){
              echo CartBtnCookie($results[0]->item_id);
            }
            ?>">
            <?php
            //if user is logged in
            if(isset($_SESSION['name'])){
              if(empty($itemInCart)){
                echo 'Add To Bag'; }
              else{
                echo 'In Cart';
              }
            }else{
              //if user is NOT logged in 
              echo QuickCartBtnCookie($results[0]->item_id);
            }

            ?>
            </div>
          <h6>Free standard shipping on all orders over 50€.</h6>
          <hr>
          <div id="product-details">
            <h6 class="details-header details-first">Product Details</h6>
            <h6 class="details-header">description</h6>
            <h6 class="details-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias eligendi doloremque iste unde assumenda similique voluptate nulla dolorum quae architecto provident aperiam officiis exercitationem nostrum cupiditate, aut esse error doloribus harum distinctio. Voluptatum tenetur error sequi reiciendis placeat doloribus aperiam, rem quia, architecto modi quod earum perspiciatis suscipit nam? Sapiente beatae, dolores ipsam quis voluptatum maiores porro ad excepturi recusandae?</h6>
            <h6 class="details-header">DETAILS</h6>
            <h6 class="details-content">
              <p>65% polyester, 35% cotton. Machine wash warm</p>
              <p>Imported</p>
              <p>Art.No. 74-8900</p>
              <p>Product No. 0501616001</p>
            </h6>
          </div>
        </div>
      </section>
      <div id="product-details" class="container">
      </div>
      <div id="vertical-spacing"></div>
      <!-- PARALLAX BREAK -->
      <section id="parallax-two">
        <div class="container">
          <h2 id="parallax-title">We love your opinion</h2>
          <h4 id="parallax-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate praesentium odio pariatur officia minima iure rem, quasi, assumenda commodi quia illo voluptatum, ut harum dolores voluptates repellendus. Facilis, soluta a.</h4>
        </div>
      </section>
      <div id="vertical-spacing"></div>

      <!-- SIMILAR ITEMS -->
      <div id="similar-items" >
          <h1 >Similar items</h1>
          <div class="under-bar"></div>
        </div>
        <section id="item-list" class="container">
          <div class="item-holder item-margin-top">
            <?php for ($i=0; $i < sizeof($similarItems[0]) ; $i++) { ?>
            <div class="item">
              <a href="item.php?item=<?php echo $similarItems[0][$i]->id ?>">
                <img src="img/<?php echo $similarItems[0][$i]->item_main_img; ?>" alt="">
              </a>
              <div class="item-menu">
                <div>
                  <i class="fas <?php
                    $class = CheckCartItems($AllitemInCart, $similarItems[0][$i]->id);
                    echo $class;
                   ?>" id="<?php echo $similarItems[0][$i]->id; ?>"></i>
                </div>
                <div>
                  <?php
                    if(isset($_SESSION['name'])){
                      echo CheckFavoriteItem($similarItems, $i, $isItemFavorite);
                    }else{
                      echo "<a href='login.php'><i class='far fa-heart' id='{$similarItems[0][$i]->id}'></i></a>";
                    }
                  ?>
                </div>
              </div>
              <h3 class="item-name"><?php echo $similarItems[0][$i]->item_name ?></h3>
              <h4 class="price"><?php echo $similarItems[0][$i]->item_price ?>€</h4>
            </div>
            <?php }?>
          </div>
        </section>
        <?php } else {echo "<h6 id='error' class='container'> {$error}</h6>"; } ?>
      </div>

      <div id="vertical-spacing"></div>

      <?php include "../app/includes/footer.php"?>
    </div>
  </body>
  <script src="js/item.js"></script>
  <script src="js/addToBag.js"></script>
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</html>
