<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./assets/css/loginstyle.css">
  <link rel="shortcut icon" type="image/x-icon" href="./assets/img/clients/icon.ico">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (isset($_GET['error'])): ?>
      <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>

<?php
require("./conf.php");

function testinput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = testinput($_POST["email"]);
  $password = testinput($_POST["password"]);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: login.php?error=Invalid email format");
    exit();
  }

  try {
    $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT id, name, email, password, numtel FROM clients WHERE email = :email;");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
      $stored_password = $result['password'];
      // Verify the password
      if (hash_equals($stored_password, hash('sha512', $password))) {
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['name']= $result['name'];
        $_SESSION['phone']= $result['numtel'];
        $_SESSION['id']= $result['id'];
        header("Location: rent.php");
        exit();
      } else {
        header("Location: login.php?error=Incorrect password");
        exit();
      }
    } else {
      header("Location: login.php?error=User not found");
      exit();
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>
