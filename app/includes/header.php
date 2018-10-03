<?php
  require '../app/db.php';
  include "../app/functions.php";
  include "../app/includes/loading.php";
  session_start();

  //if user is not logged in but has items in cart
  if(isset($_COOKIE['id']) && !isset($_SESSION['name'])){
    $id = explode(",",$_COOKIE['id']);
    $id = "'" . implode("', '", $id);
    $id = substr($id, 0, -1);
    $id = rtrim($id, ", ");

    $results = GetPrice($pdo, "SELECT item_price FROM items WHERE id IN ({$id})", $id);
    $total = CalculatePrice($results);

  }
  //user is not logged in and has no items in cart
  else if(!isset($_COOKIE['id']) && !isset($_SESSION['name']) ){
    $total = 0;
  }
  //user is logged
  else if(isset($_SESSION['name']) && isset($_SESSION['id'])){
    $id = $_SESSION['id'];

    //this will get the items id in the users cart
    $results = GetPrice($pdo, "SELECT * FROM cart WHERE user_id = :id" , $id);
    $listOfItems = "";
    for ($i=0; $i < sizeof($results); $i++) {
      $listOfItems .=  "'" . $results[$i]->item_id . "', ";
    }

    $listOfItems = rtrim($listOfItems, ", ");
    $id = $listOfItems;

    $results = GetPrice($pdo, "SELECT * FROM items WHERE id IN ({$id})" , $id);
    $total = CalculatePrice($results);
  }

  function GetPrice($pdo, $query, $id){
    try {
      $statement = $pdo->prepare($query);
      $statement->execute(['id' => $id]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);
      //This will check if gathering the info from the database was succsseful
      if(empty($results)){
        $error = "Your cart is empty.";
      }else{
        return $results;
      }

    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }

  //Calculates the Total price
  function CalculatePrice($results){

    if(empty($results)){
      $total = 0;
    }else{
      $total = 0;
      foreach ($results as $result) {
        $total += $result->item_price;
      }
    }
    return $total;
  }

?>
<html lang="en" dir="ltr">
  <head>
    <meta name='viewport' content="width=device-width">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mediaQueries.css">
    <link rel="stylesheet" href="css/animations.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <title></title>
  </head>
  <body>
    <!-- MOBILE MODAL -->
    <div id="mobile-modal">
      <div id="mobile-nav">
        <div class="mobile-nav-logo">
          <div class="menu-header">
            <a href="index.php"><img src="img/logo.png" alt=""></a>
          </div>
        </div>
        <div class="mobile-item-nav">
          <div class="menu-header">
            <h3 >Mens Clothes</h3>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
          <ul>
            <li><h5><a href="itemList.php?who=men&show=tshirts">T-shirt</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Hoodies</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=sweaters">Sweaters</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Sneakers</a></h5></li>
          </ul>
        </div>

        <div class="mobile-item-nav">
          <div class="menu-header">
            <h3 >Boys Clothes</h3>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
          <ul>
            <li><h5><a href="itemList.php?who=men&show=hoodies">T-shirt</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Hoodies</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Sweaters</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Sneakers</a></h5></li>
          </ul>
        </div>

        <div class="mobile-item-nav">
          <div class="menu-header">
            <h3 >Brands</h3>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
          <ul>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Nike</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Adidas</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Jordans</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Champions</a></h5></li>
          </ul>
        </div>

        <div class="mobile-item-nav">
          <div class="menu-header">
            <h3 >New Releases</h3>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
          <ul>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Clothing</a></h5></li>
            <li><h5><a href="itemList.php?who=men&show=hoodies">Sneakers</a></h5></li>
          </ul>
        </div>

      </div>
    </div>
    <!-- NAVBAR HEADER -->
    <nav>
      <div class="container">
        <!-- LEFT SIDE OF HEADER -->
        <div id="header-left">
          <!-- MOBILE HAMBURGER -->
          <div id="hameburger-holder">
            <div id="hameburger-1"></div>
            <div id="hameburger-2"></div>
            <div id="hameburger-3"></div>
          </div>
          <!-- LOGO -->
          <a href="index.php" id="logo" class="padding-top-bottom"><img src="img/logo.png" alt=""></a>
          <!-- MEN NAV  -->
          <div id="men-nav" class="nav">
            <a href="itemList.php?who=men&show=tshirts&order=new"><h4>Men</h4></a>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
          <!-- KIDS NAV  -->
          <div id="kids-nav" class="nav">
            <a href=""><h4>Kids</h4></a>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
        </div>

        <!-- RIGHT SIDE OF HEADER -->
        <div id="header-right">
          <div id="cart-nav">
            <div>
              <a href="cart.php"><i class="fas fa-shopping-cart"></i>
            </div>
            <div>
              <h6>Cart</h6>
              <h5 class="price"><?php
              if($total == 0){
                echo "0€";
              }else{
                echo $total . '€';
              } ?></h5></a>
            </div>
          </div>
          <div id="user-nav" class="nav">
            <?php
              if(isset($_SESSION['name'])){
                echo "<a href='dashboard.php'><i class='fas fa-user'></i></a>";
                echo "<a href='dashboard.php'><h5>{$_SESSION['name']}</h5></a>";
              }else{
                echo "<a href='login.php'><i class='fas fa-user'></i></a>";
                echo "<a href='login.php'><h5>Login</h5></a>";
              }
            ?>
            <i class="fas fa-sort-down sort-down"></i>
          </div>
        </div>
      </div>
      <!-- MEN MENU -->
      <section id="men-menu" class="menu">
        <div class="container">
          <div class="menu-item">
            <h3 class="menu-header">Mens Clothes</h3>
            <ul>
              <li><h5><a href="itemList.php?who=men&show=tshirts">T-shirt</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Hoodies</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=sweaters">Sweaters</a></h5></li>
            </ul>
          </div>

          <div class="menu-item">
            <h3 class="menu-header">Under 40€</h3>
            <ul>
              <li><h5><a href="itemList.php?who=men&show=tshirts&order=new&price=2.4">T-shirt</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies&order=new&price=2.4">Hoodies</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=sweaters&order=new&price=2.4">Sweaters</a></h5></li>
            </ul>
          </div>

          <div class="menu-item">
            <a href="itemList.php?who=men&show=tshirts&order=new">
            <img src="img/sale.jpg" alt="">
            </a>
          </div>
        </div>
      </section>
      <!-- KIDS MENU -->
      <section id="kids-menu" class="menu">
        <div class="container">
          <div class="menu-item">
            <h3 class="menu-header">Boys Clothes</h3>
            <ul>
              <li><h5><a href="itemList.php?who=men&show=tshirts">T-shirt</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Hoodies</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=sweaters">Sweaters</a></h5></li>
            </ul>
          </div>
          <div class="menu-item">
            <h3 class="menu-header">Brands</h3>
            <ul>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Nike</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Adidas</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Jordans</a></h5></li>
            </ul>
          </div>
          <div class="menu-item">
            <h3 class="menu-header">New Releases</h3>
            <ul>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Clothing</a></h5></li>
              <li><h5><a href="itemList.php?who=men&show=hoodies">Sneakers</a></h5></li>
            </ul>
          </div>
        </div>
      </section>
      <!-- ACCOUNT NAV -->
      <section id="user-menu" class="menu">
        <div class="container">
          <div class="menu-item">
            <h3 class="menu-header">Account Options</h3>
            <?php
              if(isset($_SESSION['name'])){
                echo "
                <ul>
                  <li><h5><a href='dashboard.php'>Settings</a></h5></li>
                  <li><h5><a href='cart.php'>Shopping Cart</a></h5></li>
                  <li><h5><a href='favorite.php'>Favorites</a></h5></li>
                  <li><h5><a href='logout.php'>Log Out</a></h5></li>
                </ul>";
              }else{
                echo "
                <ul>
                <li><h5><a href='login.php'>Settings</a></h5></li>
                <li><h5><a href='login.php'>Shopping Cart</a></h5></li>
                <li><h5><a href='register.php'>Register</a></h5></li>
                <li><h5><a href='login.php'>Log In</a></h5></li>
                </ul>";
              }
            ?>
          </div>
        </div>
      </section>
    </nav>
    </section>
