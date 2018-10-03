<?php
  $error = "";
  ////if the user is NOT logged in
  if(isset($_SESSION['id']) && isset($_SESSION['name'])){
    $data['id'] = $_SESSION['id'];
    try {
      $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
      $statement->execute(['id' => $data['id']]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);
      //This will check if gathering the info from the database was succsseful
      if(empty($results)){
        $error = "User doesn't exist";
      }
    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }
?>
