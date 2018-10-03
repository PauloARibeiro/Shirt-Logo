<?php
 $error = "";
  ////if the user is NOT logged in
 if(isset($_COOKIE['id']) && !isset($_SESSION['name'])){
   $id = explode(",",$_COOKIE['id']);
   $id = "'" . implode("', '", $id);
   $id = substr($id, 0, -1);
   $id = rtrim($id, ", ");

   $results = GetItem($pdo, "SELECT * FROM items WHERE id IN ({$id})", $id);
   $similarItems = SimilarItems($pdo);
   $AllitemInCart = GetallItemsInCart($pdo);
 }
//if the user is logged in
 else if(isset($_SESSION['name']) && isset($_SESSION['id'])){
   $id = $_SESSION['id'];

   $cart = GetItem($pdo, "SELECT * FROM cart WHERE user_id = :id" , $id);
   $listOfItems = "";

   for ($i=0; $i < sizeof($cart); $i++) {
     $listOfItems .=  "'" . $cart[$i]->item_id . "', ";
   }

   $listOfItems = rtrim($listOfItems, ", ");
   $id = $listOfItems;

   $results = GetItem($pdo, "SELECT * FROM items WHERE id IN ({$id})" , $id);
   $similarItems = SimilarItems($pdo);
   $AllitemInCart = GetallItemsInCart($pdo);
   $isItemFavorite = GetFavoriteItems($pdo);
 }

function GetItem($pdo, $query, $id){
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

//This will grab the most Popular items
function SimilarItems($pdo){
  try{
    $statement = $pdo->prepare(
      "SELECT * FROM items ORDER BY item_views DESC LIMIT 6"
    );
    $statement->execute();
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
  for ($o=0; $o < sizeof($similarItems) ; $o++) {
    if(isset($isItemFavorite[$o]->item_id)){
      if($isItemFavorite[$o]->item_id == $similarItems[$i]->id){
        $class = "<i class='fas fa-heart' id='{$similarItems[$i]->id}'></i>";
        return $class;
      }else{
        $class = "<i class='far fa-heart' id='{$similarItems[$i]->id}'></i>";
      }
    }else{
      $class = "<i class='far fa-heart' id='{$similarItems[$i]->id}'></i>";
      return $class;
    }
  }
  return $class;
}

?>
