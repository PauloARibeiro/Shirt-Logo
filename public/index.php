<?php include "../app/includes/header.php"; ?>
<?php include "../app/includes/addToBag.php"; ?>
<?php include "itemFilters.php" ?>
<?php
try{
  $statement = $pdo->prepare(
    "SELECT * FROM items ORDER BY item_views DESC LIMIT 6"
  );
  $statement->execute();
  $results =  $statement->fetchAll(PDO::FETCH_OBJ);
  if(!empty($results)){
    $AllitemInCart = GetallItemsInCart($pdo);
    $isItemFavorite = GetFavoriteItems($pdo);
  }
} catch (PDOException $e) {
  $error = "{$e->getMessage()}";
}
?>
<!-- BODY -->
<div id="content-body">
  <!-- SLIDER INTRO -->
  <section id="slider">
    <div class="container">
      <div id="slider-content">
        <h1 id="slider-title"><span>summer</span> collection</h1>
        <h3 id="slider-sub-title">30% off</h3>
        <a href="itemList.php?who=men&show=tshirts&order=new" class="btn btn-red">SHOP SUMMER</a>
      </div>
    </div>
  </section>

  <div id="vertical-spacing"></div>

  <!-- BLOCK SECTION -->
  <section id="blocks" class="cirlces-background">
    <div class="container">
      <div id="blocks-flex">
        <div class="block-item shadow">
          <a href="itemList.php?who=men&show=tshirts">
            <img src="img/section01_01.jpeg" alt="">
            <h2 id="block-title">t-shirts</h2>
            <h4 id="block-sub-title">under 20€</h4>
          </a>
          <a href="itemList.php?who=men&show=tshirts" class="btn btn-transparent">Shop T-shirts</a>
        </div>

        <div id="horizontal-spacing"></div>

        <div class="block-item shadow">
          <a href="itemList.php?who=men&show=sweaters">
            <img src="img/section01_02.jpeg" alt="">
            <h2 id="block-title">sweaters</h2>
            <h4 id="block-sub-title">under 40€</h4>
          </a>
          <a href="itemList.php?who=men&show=sweaters" class="btn btn-transparent">Shop sweaters</a>
        </div>
      </div>

      <div id="blocks-flex">
        <div class="block-item shadow">
          <a href="itemList.php?who=men&show=hoodies">
            <img src="img/section01_03.jpeg" alt="">
            <h2 id="block-title">hoodies</h2>
            <h4 id="block-sub-title">under 40€</h4>
          </a>
          <a href="itemList.php?who=men&show=hoodies" class="btn btn-transparent">Shop hoodies</a>
        </div>

        <div id="horizontal-spacing"></div>

        <div class="block-item shadow">
          <a href="itemList.php?who=men&show=tshirts">
            <img src="img/section01_04.jpeg" alt="">
            <h2 id="block-title">new </h2>
            <h4 id="block-sub-title">releases</h4>
          </a>
          <a href="itemList.php?who=men&show=tshirts" class="btn btn-transparent">Shop releases</a>
        </div>
      </div>
    </div>
  </section>

  <div id="vertical-spacing"></div>

  <!-- FEATURES -->
  <section id="features" class="container">
    <div class="features-item ">
      <img src="img/model-02.jpeg" alt="">
      <div id="features-content">
        <h1 id="feature-title">kids</h1>
        <h4 id="feature-sub-title">Kids with style.</h4>
        <div class="button-holder">
          <a href="itemList.php?who=men&show=tshirts&order=new" class="btn btn-purple">shop kids</a>
        </div>
      </div>
    </div>

    <div class="features-item">
      <div id="features-content">
        <h1 id="feature-title" class="feature-title-2">just landed</h1>
        <h4 id="feature-sub-title">New summer clothing. GET IT NOW!</h4>
        <div class="button-holder">
          <a href="itemList.php?who=men&show=tshirts&order=new" class="btn btn-purple">New Releases</a>
        </div>
      </div>
      <img src="img/model-01.jpeg" alt="">
    </div>
  </section>

  <div id="vertical-spacing"></div>

  <!-- POPULAR -->
  <section id="item-list" class="container">
    <div class="body-header">
      <h1 >Popular</h1>
      <div class="under-bar"></div>
    </div>
    <div class="item-holder">
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

  <div id="vertical-spacing"></div>

  <!-- PARALLAX BREAK -->
  <section id="parallax">
    <div class="container">
      <h2 id="parallax-title">the best quality</h2>
      <h4 id="parallax-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur fuga illum reprehenderit minus veniam possimus culpa repudiandae in ullam neque harum consectetur quia, aperiam beatae repellat labore porro, voluptate est magnam ab dolores. Voluptatem accusantium, maiores, eaque illo cumque culpa nulla perferendis! Eveniet amet sapiente ipsa, ea dicta architecto! Quasi.</h4>
    </div>
  </section>

  <div id="vertical-spacing"></div>

  <!-- MORE INFO -->
  <section id="more-info" class="container cirlces-background">
    <div class="body-header">
      <h1 >love it! live it!</h1>
      <div class="under-bar"></div>
    </div>
    <div id="info-top">
      <div id="event-one" class="shadow">
        <h4>shirt logo on the go!</h4>
        <h2 id="info-title">get the app!</h2>
        <h4><a href="">ios</a> <span><a href="">android</a></span></h4>
      </div>

      <div id="horizontal-spacing"></div>

      <div id="event-two" class="shadow">
        <div id="white-rectangle">
          <h4>big event</h4>
          <h2 id="info-title">crazy shirt</h2>
          <h4>weekend <span>6/10 - 6/12</span></h4>
          <a href="" class="btn btn-red">more info</a>
        </div>
      </div>
    </div>
    <div id="info-bottom" class="shadow">
      <div id="info-bottom-content">
        <h2 id="info-title">get our magazine</h2>
        <h4>100% free</h4>
        <form action="">
          <input type="text" class='shadow' placeholder="email...">
          <button class="btn btn-white">Submit</button>
        </form>
      </div>
    </div>
  </section>

  <div id="vertical-spacing"></div>

  <?php include "../app/includes/footer.php"?>
</div>
</body>
<script src="js/addToBag.js"></script>
<script src="js/headerNav.js"></script>
<script src="js/footerNav.js"></script>
<script src="js/mediaQueries.js"></script>
</html>
