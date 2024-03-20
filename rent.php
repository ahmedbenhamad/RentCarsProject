<?php
session_start();
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rent a Car</title>
  <link rel="stylesheet" href="./assets/css/rentstyle.css">
  <link rel="shortcut icon" type="image/icon" href="./assets/img/clients/icon.ico">
  <style>
  .navbar {
    background-color: #333;
    color: white;
    padding: 10px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }

  .navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .navbar-brand {
    font-size: 1.5rem;
    font-weight: bold;
    text-decoration: none;
    color: white;
  }

  .navbar-brand:hover {
    color: #ddd;
  }

  .navbar-nav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
  }

  .navbar-nav li {
    margin-right: 15px;
  }

  .navbar-nav li a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .navbar-nav li a:hover {
    background-color: #555;
  }

  .nav-item img {
    width: 20px; 
    height: 20px; 
    border-radius: 50%; 
    border: 2px solid #fff;
    transition: transform 0.3s ease; /* Add transition for smooth hover effect */
  }

  .nav-item img:hover {
    transform: scale(1.1); /* Increase size on hover */
  }
</style>




</head>
<body>
<div class="navbar">
    <div class="container navbar-container">
      <a href="#" class="navbar-brand">Rent a Car</a>
      <ul class="navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="index.html">Logout</a></li>
        <li class="nav-item">
          <a href=profile.php>
            <img src="<?php echo htmlspecialchars($_SESSION['image']); ?>" class="rounded-circle profile-image-nav" alt="Profile Image">
          </a>
          </li>
      </ul>
    </div>
  </div>
<div class="background">
  <div class="container">
    <h1>Welcome <?php echo $name; ?></h1> <!-- Display the name here -->
    <div class="car-list">
    <!-- Car 1 -->
    <div class="car">
      <img src="./assets/img/clients/Ford.png" alt="Ford">
      <div class="details">
        <h2>Ford</h2>
        <p>Price: $35/day</p>
        <label for="pickDate1">Pick-up Date:</label>
        <input type="date" id="pickDate1" name="pickDate1">
        <label for="returnDate1">Return Date:</label>
        <input type="date" id="returnDate1" name="returnDate1">
        <label for="location1">Location:</label>
        <select id="location1" name="location1">
          <option value="location1">Tunis</option>
          <option value="location2">Sousse</option>
          <option value="location3">Sfax</option>
        </select>
        <button onclick="rentCar(1)">Rent Now</button>
      </div>
    </div>
    <!-- Car 2 -->
    <div class="car">
      <img src="./assets/img/clients/golf7.png" alt="Golf 7">
      <div class="details">
        <h2>Golf 7</h2>
        <p>Price: $60/day</p>
        <label for="pickDate2">Pick-up Date:</label>
        <input type="date" id="pickDate2" name="pickDate2">
        <label for="returnDate2">Return Date:</label>
        <input type="date" id="returnDate2" name="returnDate2">
        <label for="location2">Location:</label>
        <select id="location2" name="location2">
          <option value="location1">Tunis</option>
          <option value="location2">Sousse</option>
          <option value="location3">Sfax</option>
        </select>
        <button onclick="rentCar(2)">Rent Now</button>
      </div>
    </div>

    <!-- Car 3 -->
    <div class="car">
        <img src="./assets/img/clients/White-Mini-Cooper.png" alt="Ford">
        <div class="details">
          <h2>Mini Cooper</h2>
          <p>Price: $50/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 4 -->
    <div class="car">
        <img src="./assets/img/clients/Renault-Megane.png" alt="Ford">
        <div class="details">
          <h2>Renault Megane</h2>
          <p>Price: $45/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 5 -->
    <div class="car">
        <img src="./assets/img/clients/Volkswagen8.png" alt="Ford">
        <div class="details">
          <h2>Golf 8</h2>
          <p>Price: $55/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 6 -->
    <div class="car">
        <img src="./assets/img/clients/kia.jpg" alt="Ford">
        <div class="details">
          <h2>Kia Sportage</h2>
          <p>Price: $52/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 7 -->
    <div class="car">
        <img src="./assets/img/clients/hundai.jpg" alt="Ford">
        <div class="details">
          <h2>Hundai</h2>
          <p>Price: $30/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 8 -->
    <div class="car">
        <img src="./assets/img/clients/golf8.png" alt="Ford">
        <div class="details">
          <h2>Golf</h2>
          <p>Price: $40/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 9 -->
    <div class="car">
        <img src="./assets/img/clients/golf7.png" alt="Ford">
        <div class="details">
          <h2>Golf 7</h2>
          <p>Price: $37/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
    <!-- Car 10 -->
    <div class="car">
        <img src="./assets/img/clients/Ford-Transit.jpg" alt="Ford">
        <div class="details">
          <h2>Ford Transit</h2>
          <p>Price: $60/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
      <!--Car 11 -->
      <div class="car">
        <img src="./assets/img/clients/BMW.jpg" alt="Ford">
        <div class="details">
          <h2>BMW</h2>
          <p>Price: $54/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
      <!--Car 12-->
      <div class="car">
        <img src="./assets/img/clients/audi.png" alt="Ford">
        <div class="details">
          <h2>Audi</h2>
          <p>Price: $58/day</p>
          <label for="pickDate1">Pick-up Date:</label>
          <input type="date" id="pickDate1" name="pickDate1">
          <label for="returnDate1">Return Date:</label>
          <input type="date" id="returnDate1" name="returnDate1">
          <label for="location1">Location:</label>
          <select id="location1" name="location1">
            <option value="location1">Tunis</option>
            <option value="location2">Sousse</option>
            <option value="location3">Sfax</option>
          </select>
          <button onclick="rentCar(1)">Rent Now</button>
        </div>
      </div>
  </div>
</div>
</div>

<script src="script.js"></script>
</body>
</html>
