<?php
session_start();
include "../app/db.php";
 if(isset($_GET['add']) && isset($_GET['size'])){

   $data = [
     "item_id" => $_GET['add']
   ];

   try {
     $statement = $pdo->prepare(
       "SELECT * FROM items WHERE id = :id"
     );
     $statement->execute(['id' => $data['item_id']]);
     $results = $statement->fetchAll(PDO::FETCH_OBJ);
     //This will check if gathering the info from the database was succsseful
     if(empty($results)){
       $error = "Oops something went wrong. <br><br>The programmers say the id of the current product doesn't exist.";
     }else{

       if(isset($_SESSION['name']) && isset($_SESSION['id'])){
         $data["selected_size"] = $_GET['size'];
         $data['user_id'] = $_SESSION['id'];
         CheckUserCart($data, $pdo);
       }else{
         $results['false'] = true;
       }
       //InsertItemToCart($data, $pdo);
       echo json_encode($results);
     }
   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
   //this will insert item to the favorites list
 }elseif (isset($_GET['fav']) && isset($_GET['add']) && isset($_SESSION['id'])){

   $data = [
     "item_id" => $_GET['add'],
     "user_id" => $_SESSION['id'],
     "favorite" => $_GET['fav']
   ];

   try {
     $statement = $pdo->prepare(
       "SELECT * FROM favorite WHERE item_id = :item_id AND user_id = :user_id"
     );
     $statement->execute(['item_id' => $data['item_id'], 'user_id' => $data['user_id']]);
     $results = $statement->fetchAll(PDO::FETCH_OBJ);

     if(empty($results)){
       InsertFavorite($data, $pdo);
     }
   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
  //this will delete item from the favorites list
 }elseif (isset($_GET['fav']) && isset($_GET['remove']) && isset($_SESSION['id'])){

   $data = [
     "item_id" => $_GET['remove'],
     "user_id" => $_SESSION['id'],
   ];

   DeleteFavorite($data, $pdo);

 }else{
   echo "false";
 }

//this will check if the current selected item is alredy in the user cart
 function CheckUserCart($data, $pdo){
   try {
     $statement = $pdo->prepare(
       "SELECT * FROM cart WHERE item_id = :item_id AND user_id = :user_id AND selected_size = :selected_size"
     );
     $statement->execute(['item_id' => $data['item_id'], 'user_id' => $data['user_id'], 'selected_size' => $data['selected_size']]);
     $results = $statement->fetchAll(PDO::FETCH_OBJ);

     if(empty($results)){
       InsertItemToCart($data, $pdo);
     }
   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
 }

//will insert current item into the user cart
 function InsertItemToCart($data, $pdo){
   try {
     $statement = $pdo->prepare(
       'INSERT INTO cart (item_id, user_id, selected_size) VALUES (:item_id, :user_id, :selected_size);'
     );
     $statement->execute(['item_id' => $data['item_id'], 'user_id' => $data['user_id'], 'selected_size' => $data['selected_size']]);

   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
 }

//will insert item to Favorites
 function InsertFavorite($data, $pdo){
   try {
     $statement = $pdo->prepare(
       'INSERT INTO favorite (item_id, user_id, favorite) VALUES (:item_id, :user_id, :favorite);'
     );
     $statement->execute(['item_id' => $data['item_id'], 'user_id' => $data['user_id'], 'favorite' => $data['favorite']]);

   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
 }

 //will insert item to Favorites
  function DeleteFavorite($data, $pdo){
    try {
      $statement = $pdo->prepare(
        'DELETE FROM favorite WHERE item_id = :item_id AND user_id = :user_id'
      );
      $statement->execute(['item_id' => $data['item_id'], 'user_id' => $data['user_id']]);

    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }
?>
