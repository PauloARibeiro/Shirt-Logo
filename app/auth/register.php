<?php
  $error = "";
  //create new user
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //SANITIZES DATA
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //GETS VALUES FROM INPUTS
    $data = [
      "first_name" => trim($_POST['first_name']),
      "last_name" => trim($_POST['last_name']),
      "email" => trim($_POST['email']),
      "password" => trim($_POST['password']),
      "confirm_password" => trim($_POST['confirm_password'])
    ];

    //SANITIZE EMAIL
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    //VALIDATES FORMS
    $type = 'register';
    $validation = UserAuth($data, $pdo, $type);
    $error = $validation[1];

    //HASH PASSWORD
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    //IF ALL FIELDS ARE FILED INSERT INTO DATABASE
    if($validation[0] == 1){
      try {
        $statement = $pdo->prepare(
          'INSERT  INTO users (first_name, last_name, email, password) VALUES (:first_name,:last_name, :email, :password);'
        );
        $statement->execute(['first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'password' => $data['password']]);

      } catch (PDOException $e) {
          $error = "{$e->getMessage()}";
      }
    }
  }
?>
