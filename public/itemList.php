<?php include "../app/includes/header.php"; ?>
<?php include "../app/includes/addToBag.php"; ?>
<?php include "itemFilters.php" ?>
    <!-- BODY -->
    <div id="content-body">
        <div id="item-header">
          <h2 id="item-path-title">Men's <span>Clothing</span></h2>
        </div>
        <div id="item-sort" class="container">
          <h4>Sort</h4>
          <ul id="sort-menu">
            <li >Newest First <i class="fas fa-sort-down sort-down"></i></li>
            <li>Price (highest first) </li>
            <li>Price (lowest first) </li>
          </ul>
        </div>
        <!-- MOBILE SORT -->
        <div id="item-sort" >
          <select name="" id="sort-list" class="mobile-sort" onchange="itemFilter.MobileOrderFilter(this.value)">
            <option value="" disabled selected hidden>Sort</option>
            <option value="new">Newest First</option>
            <option value="high">Price (highest first)</option>
            <option value="low">Price (lowest first)</option>
          </select>
          <span id="redefine-btn" class="mobile-sort">
            Redefine
          </span>
        </div>
        <div id="vertical-spacing-listing"></div>
      <div id="item-list-holder"  class="container">
        <section id="item-filters">
          <div class="filter-item">
            <h4>categories</h4>
            <ul>
              <li><a href="itemList.php?who=men&show=tshirts&order=new">T-shirts</a></li>
              <li><a href="itemList.php?who=men&show=hoodies&order=new">Hoodies</a></li>
              <li><a href="itemList.php?who=men&show=sweaters&order=new">Sweaters</a></li>
              <!-- <li><a href="itemList.php?who=men&show=sneakers">Sneakers</a></li> -->
            </ul>
          </div>

          <div class="filter-item">
            <h4>Price</h4>
            <form action="">
              <ul>
                <li><input type="radio" name="price" value="20" class="price-filter"> < 20€</li>
                <li><input type="radio" name="price" value="20-40" class="price-filter"> 20€ - 40€</li>
                <li><input type="radio" name="price" value="40-60" class="price-filter"> 40€ - 60€</li>
                <li><input type="radio" name="price" value="60+" class="price-filter"> 60€ +</li>
              </ul>
            </form>
          </div>

          <div class="filter-item">
            <h4>Size</h4>
            <ul id="filter-sizes">
              <li><input type="checkbox" class="size"> XS</li>
              <li><input type="checkbox" class="size"> S</li>
              <li><input type="checkbox" class="size"> M</li>
              <li><input type="checkbox" class="size"> L</li>
            </ul>
          </div>

          <div class="filter-item">
            <h4>Color</h4>
            <ul id="filter-colors">
              <li><input type="checkbox"> Black</li>
              <li><input type="checkbox"> Red</li>
              <li><input type="checkbox"> Yellow</li>
              <li><input type="checkbox"> Green</li>
              <li><input type="checkbox"> Blue</li>
            </ul>
          </div>
        </section>
        <!-- ITEM LIST -->
        <section id="item-list" class="item-move-right">
          <h6 id="error"><?php echo $error; ?></h6>
          <div class="item-holder item-margin-top">
            <?php if(!empty($results)){
               foreach ($results as $result) {
              ?>
              <div class="item">
                <a href="<?php echo 'item.php?item='. $result->id ?>">
                  <img src="img/<?php echo $result->item_main_img; ?>" alt="">
                </a>
                <div class="item-menu">
                  <div>
                    <i class="fas  <?php
                      $class = CheckCartItems($AllitemInCart, $result->id);
                      echo $class;
                     ?>" id="<?php echo $result->id?>"></i>
                  </div>
                  <div>
                    <?php
                      if(isset($_SESSION['name'])){
                        echo CheckFavoriteItem($result->id, $isItemFavorite);
                      }else{
                        echo "<a href='login.php'><i class='far fa-heart' id='{$result->id}'></i></a>";
                      }
                    ?>
                  </div>
                </div>
                <h3 class="item-name"><?php echo $result->item_name; ?></h3>
                <h4 class="price"><?php echo $result->item_price; ?>€</h4>
              </div>
            <?php }
              }else{
                $error = "No matches found";
              };?>
          </div>

        </section>
      </div>

      <div id="vertical-spacing"></div>


  </body>
  <script src="js/itemFilter.js"></script>
  <script src="js/addToBag.js"></script>
  <script src="js/itemList.js"></script>
  <script src="js/headerNav.js"></script>
  <script src="js/footerNav.js"></script>
  <script src="js/mediaQueries.js"></script>
</html>
