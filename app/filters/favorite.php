<?php
  $data = [
    "user_id" => $_SESSION['id'],
    "favorite" => 1
  ];

  try {
    $statement = $pdo->prepare(
      "SELECT * FROM favorite WHERE user_id = :user_id AND favorite = :favorite"
    );
    $statement->execute(['user_id' => $data['user_id'], 'favorite' => $data['favorite']]);
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    //This will check if gathering the info from the database was succsseful
    if(empty($results)){
      $error = "You favorite items list seems empty... Too empty.";
    }else{
      $id = "";
      foreach ($results as $result) {
        $id .= "'{$result->item_id}', ";
      }
      $id = substr($id, 0, -1);
      $id = rtrim($id, ", ");

      $results = GetItems($id, $pdo);
      $AllitemInCart = GetallItemsInCart($pdo);
    }
  } catch (PDOException $e) {
    $error = "{$e->getMessage()}";
  }

  function GetItems($id, $pdo){
    try {
      $statement = $pdo->prepare(
        "SELECT * FROM items WHERE id IN ({$id})"
      );
      $statement->execute(['id' => $id]);
      return $statement->fetchAll(PDO::FETCH_OBJ);

    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }

  //This will check if the user is logged in and set the quick cart to a check or a cartt
  function CheckCartItems($AllitemInCart, $similarItems){
    $class = "";
    if(isset($_SESSION['id'])){
      //if the user is logged in and has 0 items in cart
      if(sizeof($AllitemInCart) == 0){
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

  //This will check if the user is logged in and set the quick cart to a check or a cartt
  function GetallItemsInCart($pdo){
    if(isset($_COOKIE['id']) && !isset($_SESSION['name'])){
      $results = explode(",",$_COOKIE['id']);
      $results = "'" . implode("', '", $results);
      $results = substr($results, 0, -1);
      $results = rtrim($results, ", ");

      return $results;
    }

    if(isset($_SESSION['id'])){
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
    return $results;
  }
?>
