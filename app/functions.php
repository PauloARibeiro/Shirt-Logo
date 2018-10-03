<?php
  $error = "";
  //USER AUTHICTION FOR THE REGISTER AND LOGIN FORMS
  function UserAuth($data, $pdo, $type){
    //chekcs if fields Are empty
    if(empty($data['email']) || empty($data['password'])){
      return array(false, "All fields must be filed out");
    }
    //If the confirm_pssword field is not null then validate the field
    if($data['confirm_password'] !== null){
      //checks if confirm_pssword field is empty
      if(empty($data['confirm_password']) || empty($data['first_name']) || empty($data['last_name'])){
        return array(false, "All fields must be filed out");
      }
      //checks if passwords match
      if($data['password'] != $data['confirm_password']){
        return array(false, "Passwords must match");
      }
    }
    //checks Email format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      return array(false, "Invalid email format");
    }
    // checks if email is taken
    if($type == 'register'){
      $emailTaken = EmailExists($data['email'], $pdo);
      if($emailTaken){
        return array(false, "Email is taken");
      }
    }
    //checks password length
    if(strlen($data['password']) < 8){
      return array(false, "Password must have at least 8 characters");
    }
    //checks if password contains at least one upper case and lowe case character
    if(!preg_match('/[A-Z]/', $data['password']) || !preg_match('/[a-z]/', $data['password'])){
      return array(false, "Password must contain 1 uppercase and 1 lowercase character");
    }
    //checks if the password contains at least one special character
    if(!preg_match("/[$&+,:;=?@#|'<>.^*()%!-]/", $data['password'])){
      return array(false, "Password must contain at least 1 special character");
    }

    return array(true, 'User Created');
  }

  function EmailExists($email, $pdo){
    try {
      $statement = $pdo->prepare("SELECT email FROM users WHERE email = :email");
      $statement->execute(['email' => $email]);
      $results = $statement->fetchAll(PDO::FETCH_OBJ);

      if(empty($results)){
        return false;
      }else{
        return true;
      }
    } catch (PDOException $e) {
      $error = "{$e->getMessage()}";
    }
  }

  //Checks if credentials are correct
  function Login($emailResult, $passwordResult, $data, $pdo){
    //checks if email is correct
    if($data['email'] !== $emailResult){
      return "Email not found";
    }
    //Gets hashed password
    $hashed_password = $passwordResult;
    //checks if password is correct
    if(password_verify($data['password'], $hashed_password)){
      UserSession($data, $pdo);
    }else{
      return "Password is incorrect";
    }
  }
  // Crete user session
  function UserSession($data, $pdo){
    $_SESSION['name'] = $data['first_name'];
    $_SESSION['id'] = $data['id'];
    echo "<script>location='index.php'</script>";
    
    AddCartItems($pdo);
  }

?>
