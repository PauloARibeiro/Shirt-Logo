<?php
if(isset($_SESSION['name'])){
  echo "<script>location='index.php'</script>";
}else{
  $error = "";
  //create new user
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //SANITIZES DATA
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //GETS VALUES FROM INPUTS
    $data = [
      "id" => null,
      "first_name" => null,
      "last_name" => null,
      "email" => trim($_POST['email']),
      "password" => trim($_POST['password']),
      "confirm_password" => null
    ];

    //SANITIZE EMAIL
    $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    //VALIDATES FORMS
    $type = 'login';
    $validation = UserAuth($data, $pdo, $type);
    $error = $validation[1];

    //IF ALL FIELDS ARE FILED
    if($validation[0] == 1){
      try {
        $statement = $pdo->prepare(
          'SELECT * FROM users WHERE email = :email;'
        );
        $statement->execute(['email' => $data['email']]);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        //Checks to see if email and password are valid
        $data['first_name'] = $result[0]->first_name;
        $data['id'] = $result[0]->id;
        $error = Login($result[0]->email, $result[0]->password, $data, $pdo);

      } catch (PDOException $e) {
        $error = "{$e->getMessage()}";
      }
    }
  }
}
?>
