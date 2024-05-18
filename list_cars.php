<?php
session_start();
require_once 'conf.php';

// Check if the session variable is set, otherwise assign an empty string
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";

try {
    // Establish a connection to the database using PDO
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    // Configure PDO if necessary
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query to fetch car data from the database
    $stmt = $pdo->query("SELECT * FROM voiture");
    // Fetch all rows as an associative array
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($cars)) {
        $_SESSION["carID"] = $cars[0]["id_voiture"];
    }

    // Optional: close the cursor to free resources
    $stmt->closeCursor();

} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}

function renderCar($car) {
    echo '<div class="car">';
    echo '<img src="./assets/img/clients/' . $car['marque'] . '.png" alt="' . $car['marque'] . '">';
    echo '<div class="details">';
    echo '<h2>' . $car['marque'] . '</h2>';
    echo '<p>Price: $' . $car['prix_par_jour'] . '/day</p>';
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
    .btn-danger { background-color: red; }
    a { text-decoration: none; color: white; }
</style>
<body>
<div class="navbar">
    <div class="navbar">
        <div class="container navbar-container">
            <a href="#" class="navbar-brand">Cars List</a>
            <ul class="navbar-nav">
                <li><a href="control_panel.php">Control Panel</a></li>
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
                <div class="car" id="car_<?php echo $car['id_voiture']; ?>">
                    <img src="./assets/img/clients/<?php echo htmlspecialchars($car['marque']); ?>.png" alt="<?php echo htmlspecialchars($car['marque']); ?>">
                    <div class="details">
                        <h2><?php echo htmlspecialchars($car['marque']); ?></h2>
                        <p>Price: $<?php echo htmlspecialchars($car['prix_par_jour']); ?>/day</p>
                        <button class="btn btn-primary" onclick="location.href='updateCar.php?id=<?php echo $car['id_voiture']; ?>';">Update</button>
                        <button class="btn btn-danger" onclick="removeCar(<?php echo $car['id_voiture']; ?>)">Remove</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    function removeCar(carId) {
        if (confirm('Are you sure you want to remove this car?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'removeCar.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Remove the car element from the DOM
                    document.getElementById('car_' + carId).remove();
                    alert('Car removed successfully');
                } else {
                    alert('Error: ' + xhr.responseText);
                }
            };
            xhr.send('id=' + carId);
        }
    }
</script>
</body>
</html>
