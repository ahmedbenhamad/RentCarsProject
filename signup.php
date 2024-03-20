<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <link rel="stylesheet" href="./assets/css/signupstyle.css">
  <link rel="shortcut icon" type="image/icon" href="./assets/img/clients/icon.ico">
</head>
<body>
  <div class="signup-container">
    <h2>Sign Up</h2>
    <form action="signup.php" method="POST">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="cin">CIN :</label>
        <input type="text" id="cin" name="cin" required>
      </div>
      <div class="form-group">
        <label for="telephone">Telephone Number:</label>
        <input type="tel" id="telephone" name="telephone" required>
      </div>
      <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
      </div>
      <div class="form-group">
        <label for="license">Driver's License:</label>
        <input type="text" id="license" name="license" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
      </div>
      <div id="error-message"></div>
      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>



<?php

require_once("./conf.php");

function testinput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = testinput($_POST["name"]);
    $email = testinput($_POST["email"]);
    $password = testinput($_POST["password"]);
    $hashed_password = hash('sha512', $password);
    $CIN = testinput($_POST["cin"]);
    $numtel = testinput($_POST["telephone"]);
    $age = testinput($_POST["age"]);
    $licenseNum = testinput($_POST["license"]);
    $conf_password = testinput($_POST["confirm-password"]);
    
    if($password == $conf_password){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";  
        try {
            $conn = new PDO($dsn, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
            $sql = "INSERT INTO clients (name, email, CIN, age, licenseNum, password, numtel) 
                    VALUES (:name, :email, :CIN, :age, :licenseNum, :password, :numtel)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':CIN', $CIN);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':licenseNum', $licenseNum);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':numtel', $numtel);
            $stmt->execute();
            echo "<script>alert('Your account has been created');window.location.href='./login.php';</script>";
            
        } catch(PDOException $e) {
          echo "<script>document.getElementById('error-message').innerHTML = 'Error: " . $e->getMessage() . "';</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match');</script>";
    }
} 
?>
