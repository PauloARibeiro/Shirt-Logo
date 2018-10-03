<?php
  $error = "";
  $data = [];
  //Dispalys items in the item list
  if(isset($_GET['show'])  && isset($_GET['who'])){
    //shows all men or kids clothing
    $data['who'] = $_GET['who'];
    $data['show'] = $_GET['show'];
    $results = SubmitQuery($pdo, "SELECT * FROM items WHERE item_type =:item_type AND item_who = :item_who", $data);

    if(empty($results)){
      $error = "No matches found";
    }else{
      $AllitemInCart = GetallItemsInCart($pdo);
      $isItemFavorite = GetFavoriteItems($pdo);
    }

  }elseif(isset($_GET['show'])  && isset($_GET['who']) && isset($_GET['price'])){
    //shows all men or kids clothing
    $data['who'] = $_GET['who'];
    $data['show'] = $_GET['show'];
    $data['price'] = $_GET['price'];

    $results = SubmitQuery($pdo, "SELECT * FROM items WHERE item_type =:item_type AND item_who = :item_who WHERE item_price BETWEEN 0 AND 20", $data);

    if(empty($results)){
      $error = "No matches found";
    }else{
      $AllitemInCart = GetallItemsInCart($pdo);
      $isItemFavorite = GetFavoriteItems($pdo);
    }
  }

  function SubmitQuery($pdo, $query, $data){
    try {
      $statement = $pdo->prepare($query);

      $statement->execute(['item_type' => $data['show'], 'item_who' => $data['who']]);
      return $statement->fetchAll(PDO::FETCH_OBJ);

    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
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
  function CheckFavoriteItem($result, $isItemFavorite){
    $class = "";
    for ($o=0; $o < sizeof($isItemFavorite) ; $o++) {
      if(isset($isItemFavorite[$o]->item_id)){
        if($isItemFavorite[$o]->item_id == $result){
          $class = "<i class='fas fa-heart' id='{$result}'></i>";
          return $class;
        }else{
          $class = "<i class='far fa-heart' id='{$result}'></i>";
        }
      }else{
        $class = "<i class='far fa-heart' id='{$result}'></i>";
        return $class;
      }
    }
    return $class;
  }

  //gets all items in cart
  function GetallItemsInCart($pdo){
    if(isset($_COOKIE['id']) && !isset($_SESSION['name'])){
      $results = explode(",",$_COOKIE['id']);
      $results = "'" . implode("', '", $results);
      $results = substr($results, 0, -1);
      $results = rtrim($results, ", ");

      return $results;
    }else if(isset($_SESSION['id'])){
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

  //This will check if the user is logged in and set the quick cart to a check or a cart
  function CheckCartItems($AllitemInCart, $result){
    $class = "";
    //$class = var_dump($AllitemInCart);
    if(isset($_SESSION['id'])){
      //if the user is logged in and has 0 items in cart
      if(sizeof($AllitemInCart)  == 0){
        $class = "fa-shopping-cart";
      }else{
        //if the user is logged in and has more than one item in cart
        foreach ($AllitemInCart as $item ) {
          if($item->item_id == $result){
            $class = "fa-check ";
            break;
          }else{
            $class = "fa-shopping-cart ";
          }
        }
      }
    }else{
      //if the user is not logged in
      $pos = strpos($AllitemInCart, $result);
      if($pos == true){
        $class = "fa-check ";
      }else{
        $class = "fa-shopping-cart ";
      }
    }
    return $class;
  }
?>
