<?php
    if(isset($_GET['edit'])){
      include "../app/db.php";
      $id = $_GET['edit'];
      try {
        $statement = $pdo->prepare(
          "SELECT items.*, size.* FROM items,size WHERE items.id = :id AND size.item_id = :id"
        );
        $statement->execute(['id' => $id]);
        $editItem = $statement->fetchAll(PDO::FETCH_OBJ);
        //This will check if gathering the info from the database was succsseful
        if(empty($editItem)){
          $edit_error = "Oops something went wrong. <br><br>The programmers say the id of the current product doesn't exist.";
        }else{
          echo json_encode($editItem);
        }
      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
       }
      }else{
       $error ="wrong";
      }
?>
