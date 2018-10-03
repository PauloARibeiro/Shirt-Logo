<?php
  $error = "";
  $data = [];
  $query = "";
  $execute = "";
  //if show and who is set
  if(isset($_GET['show'])  && isset($_GET['who'])){
    $data['who'] = $_GET['who'];
    $data['show'] = $_GET['show'];

    $query = "SELECT * FROM items WHERE `item_type` = :item_type AND `item_who` = :item_who";
    $execute = ['item_type' => $data['show'], 'item_who' => $data['who']];

    //if price is set
    if(isset($_GET['price'])){
      //breaks price string into array
      $prices = explode(".",$_GET['price']);
      //stores min price
      $data['item_min'] = $prices[0] . '0';
      //stores max price
      $data['item_max'] = $prices[1] . '0';

      $query .= " AND `item_price` BETWEEN :item_min AND :item_max";
      $execute += ['item_min' => $data['item_min'], 'item_max' => $data['item_max']];
    }

    if(isset($_GET['color'])){
      if($_GET['color'] != ""){
        $colors = explode("_",$_GET['color']);

        array_shift($colors);
        array_push($colors, "");

        $id = "'" . implode("', '", $colors);
        $id = substr($id, 0, -1);
        $id = rtrim($id, ", ");

        $query .= " AND `color` IN ({$id})";
      }
    }

    //this will set the list of items order
    if(isset($_GET['order'])){
      $query .= CheckOrder($_GET['order']);
    }

    $results = SubmitQuery($pdo, $query, $execute);
    //$error = $data['size'];

    if(empty($results)){
      $error = "No matches found";
      //"No matches found";
    }else{
      $AllitemInCart = GetallItemsInCart($pdo);
      $isItemFavorite = GetFavoriteItems($pdo);
    }
  }

  function CheckOrder($order){
    if($order == "new"){
      return " ORDER BY item_created_at ASC";
    }
    if($order == "low"){
      return " ORDER BY item_price ASC";
    }
    if($order == "high"){
      return " ORDER BY item_price DESC";
    }
  }

  //submits the query to the database
  function SubmitQuery($pdo, $query, $execute){
    try {
      $statement = $pdo->prepare($query);

      $statement->execute($execute);
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
