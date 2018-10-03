<?php
  // Destroy user session
  function Logout(){
    unset($_SESSION['name']);
    header('Location: login.php');
    session_destroy();
  }
?>
