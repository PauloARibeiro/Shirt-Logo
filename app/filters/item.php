<?php
//Will Dispaly item in the item page
  if(isset($_GET['item'])){
    //item id
    $id = $_GET['item'];
      try {
        $statement = $pdo->prepare(
          "SELECT items.*, size.*  FROM items, size WHERE items.id = :id AND size.item_id = :id"
        );
        $statement->execute(['id' => $id ]);
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        //This will check if gathering the info from the database was succsseful
        if(empty($results)){
          $error = "Oops something went wrong. <br><br>The programmers say the id of the current product doesn't exist.";
        }else{
          //adds one view to the item
          AddViews($results[0]->item_views, $pdo, $id);
          $similarItems[0] = SimilarItems($pdo, $results[0], $id);
          $itemInCart = IsItemInCart($pdo, $id);
          $AllitemInCart = GetallItemsInCart($pdo);
          $isItemFavorite = GetFavoriteItems($pdo);
        }
      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
      }
  }else{
    $error = "Oops something went wrong. <br><br>Try going back and select the item again.";
  }

  //Adds one view to the current item
  function AddViews($item_views, $pdo, $id){
    if(isset($_GET['item'])){
      $id = $_GET['item'];
      $item_views++;
      try{
        $statement = $pdo->prepare(
          "UPDATE items SET item_views = :item_views WHERE id = :id"
        );
        $statement->execute(['item_views' => $item_views, 'id' => $id]);
      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
      }
    }
  }

  function SimilarItems($pdo, $results, $id){
    try{
      $statement = $pdo->prepare(
        "SELECT * FROM items WHERE item_who = :item_who AND id != :id ORDER BY item_views DESC LIMIT 6"
      );
      $statement->execute(['item_who' => $results->item_who, 'id' => $id]);
      return $statement->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }

  function IsItemInCart($pdo, $item_id){
    try{
      $statement = $pdo->prepare(
        "SELECT * FROM  cart WHERE item_id = :item_id AND user_id = :user_id"
      );
      $statement->execute(['item_id' => $item_id, 'user_id' => $_SESSION['id']]);
      return $statement->fetchAll(PDO::FETCH_OBJ);

    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }

  function GetallItemsInCart($pdo){
    if(isset($_COOKIE['id']) && !isset($_SESSION['name'])){
      $results = explode(",",$_COOKIE['id']);
      $results = "'" . implode("', '", $results);
      $results = substr($results, 0, -1);
      $results = rtrim($results, ", ");

      return $results;
    }else if(isset($_SESSION['id'])){
      $id = $_SESSION['id'];
      try{
        $statement = $pdo->prepare(
          "SELECT * FROM  cart WHERE user_id = :user_id"
        );
        $statement->execute(['user_id' => $_SESSION['id']]);
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;

      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
      }
    }
  }

  //This will check if the user is logged in and set the quick cart to a check or a cartt
  function CheckCartItems($AllitemInCart, $similarItems){
    $class = "";
    if(isset($_SESSION['id'])){
      //if the user is logged in and has 0 items in cart
      if(sizeof($AllitemInCart)  == 0){
        $class = "fa-shopping-cart ";
      }else{
        //if the user is logged in and has more than one item in cart
        foreach ($AllitemInCart as $item ) {
          if($item->item_id == $similarItems){
            $class = "fa-check ";
            break;
          }else{
            $class = "fa-shopping-cart ";
          }
        }
      }
    }else{
      //if the user is not logged in
      $pos = strpos($AllitemInCart, $similarItems);
      if($pos == true){
        $class = "fa-check ";
      }else{
        $class = "fa-shopping-cart ";
      }
    }
    return $class;
  }

  //if the user is not logged in and has items in cart
  function CartBtnCookie($id){
    $class = "";
    if(isset($_COOKIE['id'])){
      $cookie_id = $_COOKIE['id'];
      //breks cookie into an array
      $cookie_id = explode(",", $cookie_id);
      //loops through cookie and checks if its id matches the current items id
      foreach ($cookie_id as $cookie_id) {
        if($cookie_id == $id){
          $class = "btn btn-disabled";
          break;
        }else{
          $class = "btn btn-purple add-to-bag";
        }
      }
    }
    return $class;
  }

  //if the user is not logged in and has items in cart
  function QuickCartBtnCookie($id){
    $class = "";
    if(isset($_COOKIE['id'])){
      $id = strpos($_COOKIE['id'], $id);
      if($id){
        $class = "In Cart";
      }else{
        $class = "Add to bag";
      }
    }else{
      $class = "Add to bag";
    }
    return $class;
  }


  //this will check the favorite items list
  function GetFavoriteItems($pdo){
    if(isset($_SESSION['id'])){
      $user_id = $_SESSION['id'];
      try {
        $statement = $pdo->prepare(
          "SELECT * FROM favorite WHERE user_id = :user_id"
        );
        $statement->execute(['user_id' => $user_id]);
        return $statement->fetchAll(PDO::FETCH_OBJ);

      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
      }
    }
  }

//this will check if the favorite item matches the item in the list
  function CheckFavoriteItem($similarItems, $i, $isItemFavorite){
    $class = "";
    for ($o=0; $o < sizeof($similarItems[0]) ; $o++) {
      if(isset($isItemFavorite[$o]->item_id)){
        if($isItemFavorite[$o]->item_id == $similarItems[0][$i]->id){
          $class = "<i class='fas fa-heart' id='{$similarItems[0][$i]->id}'></i>";
          return $class;
        }else{
           $class = "<i class='far fa-heart' id='{$similarItems[0][$i]->id}'></i>";
        }
      }else{
        $class = "<i class='far fa-heart' id='{$similarItems[0][$i]->id}'></i>";
        return $class;
      }
    }
    return $class;
  }
?>
