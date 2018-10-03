<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
      session_start();
      include "../app/db.php";

      $error = 0;

      $file_name = $_FILES['files']['name'];
      $file_tmp = $_FILES['files']['tmp_name'];
      $file_type = $_FILES['files']['type'];
      $file_size = $_FILES['files']['size'];

      $file_ext = explode('.', $file_name);
      $file_actual_ext = strtolower(end($file_ext));

      $allowed = array('png', 'jpeg', 'jpg');

      if(in_array($file_actual_ext, $allowed)){
        if ($file_size < 1048576) {
          $file_name_new = $_SESSION['id'] . "." . $file_actual_ext;
          $file_destination = __DIR__ . '/img/user_picture/' . $file_name_new;
          move_uploaded_file($file_tmp, $file_destination);
          UploadPath($pdo, $file_name_new);

        }else{
          echo 'File is too big. Max size 1mb.';
        }

      }else{
        echo "Invalid file format";
      }

    }else{
      echo 'Something went wrong. Try again.';
    }
  }else{
    echo 'Something went wrong. Try again.';
  }

function UploadPath($pdo, $file_name_new){
  $data = [
    "id" => $_SESSION['id'],
    "fileName" => $file_name_new
  ];
  try {
    $statement = $pdo->prepare(
      'UPDATE users SET user_picture = :fileName WHERE id = :id;'
    );

    $statement->execute(['id' => $data['id'], 'fileName' => $data['fileName']]);

  } catch (PDOException $e) {
      echo  $e->getMessage();
  }
}
?>
