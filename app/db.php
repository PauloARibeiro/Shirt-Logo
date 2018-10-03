<?php
  function connectDB(){
    try {
      // $database = new PDO('mysql:host=213.168.251.122;dbname=pauloari_shirtlogo', 'pauloari_paulo', 'shirtlogosuper3');
      $database = new PDO('mysql:host=localhost;dbname=shirtlogo', 'root', 'root');
      $database->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $database;
    } catch (PDOException $e) {
      echo "<h4 style='color:red;'>". $e->getMessage(). "</h4>";
    }
  }

  $pdo = connectDB();

  ?>
