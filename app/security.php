<?php
  $error = "";
  //update user info
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //SANITIZES DATA
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //GETS VALUES FROM INPUTS
    $data = [
      "first_name" => trim($_POST['first_name']),
      "last_name" => trim($_POST['last_name']),
      "email" => trim($_POST['email']),
      'address' => trim($_POST['address']),
      'country' => trim($_POST['country']),
      'state' => trim($_POST['state']),
      'city' => trim($_POST['city']),
      'postal_code' => trim($_POST['postal_code']),
      'phone_number' => trim($_POST['phone_number']),
      'id' => $_SESSION['id']
    ];

    //SANITIZE EMAIL
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    //VALIDATES FORMS
    $validation = CheckFields($data);
    $error = $validation[1];

    //IF ALL FIELDS ARE FILED INSERT INTO DATABASE
    if($validation[0] == 1){
      try {
        $statement = $pdo->prepare(
          'UPDATE users
           SET first_name = :first_name,
               last_name = :last_name,
               email = :email,
               address = :address,
               country = :country,
               state = :state,
               city = :city,
               postal_code = :postal_code,
               phone_number = :phone_number
           WHERE id = :id'
        );

        $statement->execute(['first_name' => $data['first_name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'address' => $data['address'], 'country' => $data['country'], 'state' => $data['state'], 'city' => $data['city'], 'postal_code' => $data['postal_code'], 'phone_number' => $data[phone_number], 'id' => $data['id']]);

        echo "<script>location='security.php'</script>";
        
      } catch (PDOException $e) {
          $error = "{$e->getMessage()}";
      }
    }
  }

  function CheckFields($data){
    //checks Email format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      return array(false, "Invalid email format");
    }

    if(empty($data['first_name'])){
      return array(false, "Please fill out your first name");
    }

    if(empty($data['last_name'])){
      return array(false, "Please fill out your last name");
    }

    if(!empty($data['postal_code'])){
      if(!preg_match("/[0-9-]/", $data['postal_code'])){
        return array(false, "Invalid postal code.");
      }
    }

    if(!empty($data['phone_number'])){
      if(strlen($data['phone_number']) < 9 ){
        return array(false, "Invalid phone number format.");
      }
      if(!preg_match("/[0-9-]/", $data['phone_number'])){
        return array(false, "Invalid phone number format.");
      }
    }

    $_SESSION['name'] = $_POST['first_name'];
    return array(true, "User info update");

  }
?>
