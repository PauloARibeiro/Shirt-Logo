<?php
session_start();
 if(isset($_GET['delete']) && isset($_SESSION['id'])){

   include "../app/db.php";

   $data = [
     "user_id" => $_SESSION['id'],
     "item_id" => $_GET['delete']
   ];

   try {
     $statement = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id AND item_id = :item_id");
     $statement->execute(['user_id' => $data['user_id'], 'item_id' => $data['item_id']]);

   } catch (PDOException $e) {
     $error = "{$e->getMessage()}";
   }
 }else{
   echo "empty";
 }
?>
