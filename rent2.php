<?php
session_start();
require_once 'conf.php';

// Check if the session variable is set, otherwise assign an empty string
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";
$clientId = isset($_SESSION["id"]) ? $_SESSION["id"] : "";

try {
    // Establish a connection to the database using PDO
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    // Configure PDO if necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query to fetch car data from the database
    $stmt = $pdo->query("SELECT * FROM voiture");
    // Fetch all rows as an associative array
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./assets/css/rentstyle.css">
</head>
<style>
    /* Paste the provided CSS styles here */
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
<body>
<div class="navbar">
    <div class="navbar">
        <div class="container navbar-container">
            <a href="#" class="navbar-brand">Rent a Car</a>
            <ul class="navbar-nav">
                <li><a href="index.html">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="index.html">Logout</a></li>
                <li class="nav-item">
                    <a href="profile.php">
                        <img src="<?php echo htmlspecialchars($_SESSION['image']); ?>" class="rounded-circle profile-image-nav" alt="Profile Image">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="background">
    <div class="container">
        <h1>Welcome <?php echo htmlspecialchars($name); ?></h1> <!-- Display the name here -->
        <div class="car-list">
            <!-- Render each car dynamically -->
            <?php foreach ($cars as $car) { ?>
                <div class="car">
                    <img src="./assets/img/clients/<?php echo htmlspecialchars($car['marque']); ?>.png" alt="<?php echo htmlspecialchars($car['marque']); ?>">
                    <div class="details">
                        <h2><?php echo htmlspecialchars($car['marque']); ?></h2>
                        <p>Price: $<?php echo htmlspecialchars($car['prix_par_jour']); ?>/day</p>
                        <label for="pickDate<?php echo htmlspecialchars($car['id_voiture']); ?>">Pick-up Date:</label>
                        <input type="date" id="pickDate<?php echo htmlspecialchars($car['id_voiture']); ?>" name="pickDate<?php echo htmlspecialchars($car['id_voiture']); ?>">
                        <label for="returnDate<?php echo htmlspecialchars($car['id_voiture']); ?>">Return Date:</label>
                        <input type="date" id="returnDate<?php echo htmlspecialchars($car['id_voiture']); ?>" name="returnDate<?php echo htmlspecialchars($car['id_voiture']); ?>">
                        <label for="location<?php echo htmlspecialchars($car['id_voiture']); ?>">Location:</label>
                        <select id="location<?php echo htmlspecialchars($car['id_voiture']); ?>" name="location<?php echo htmlspecialchars($car['id_voiture']); ?>">
                            <option value="Tunis" selected>Tunis</option>
                            <option value="Sousse">Sousse</option>
                            <option value="Sfax">Sfax</option>
                        </select>
                        <button onclick="rentCar(<?php echo htmlspecialchars($car['id_voiture']); ?>, <?php echo htmlspecialchars($car['prix_par_jour']); ?>)">Rent Now</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function rentCar(carId, price) {
        // Retrieve selected values
        var pickDate = document.getElementById("pickDate" + carId).value;
        var returnDate = document.getElementById("returnDate" + carId).value;
        var location = document.getElementById("location" + carId).value;

        // AJAX request to send data to PHP page for payment processing and insertion
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "facture.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle response from PHP page
                var response = xhr.responseText;
                // Display success message or handle errors
                alert(response);
            }
        };
        // Prepare data to send
        var data = "carId=" + encodeURIComponent(carId) + "&pickDate=" + encodeURIComponent(pickDate) + "&returnDate=" + encodeURIComponent(returnDate) + "&location=" + encodeURIComponent(location) + "&clientId=" + encodeURIComponent("<?php echo $clientId; ?>") + "&price=" + encodeURIComponent(price);
        // Send data
        xhr.send(data);
    }
</script>

</body>
</html>
