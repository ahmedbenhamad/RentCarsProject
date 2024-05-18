<?php
session_start();
require_once 'conf.php'; // Assuming this file contains database configuration constants

// Initialize variables
$name = ""; // Default value for the user's name
$carMarque = "";
$coutparJ = 0;
$cout = 0;
$clientId = "";

// Check if the session variable is set, otherwise assign an empty string
if (isset($_SESSION["name"])) {
    $name = $_SESSION["name"];
}
if (isset($_SESSION["id"])) {
    $clientId = $_SESSION["id"];
}

// Validate and sanitize input parameters
$id = filter_input(INPUT_GET, "carId", FILTER_VALIDATE_INT);
$pickDate = filter_input(INPUT_GET, "pickDate", FILTER_SANITIZE_STRING);
$returnDate = filter_input(INPUT_GET, "returnDate", FILTER_SANITIZE_STRING);
$location = filter_input(INPUT_GET, "location", FILTER_SANITIZE_STRING);

// Validate input parameters
if (!$id || !$pickDate || !$returnDate || !$location) {
    exit("Invalid input parameters.");
}

try {
    // Establish a connection to the database using PDO
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM voiture WHERE id_voiture = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the fetch was successful
    if ($result) {
        $carMarque = $result["marque"];
        $coutparJ = $result["prix_par_jour"];
    } else {
        exit("No data found for CarId: $id");
    }

    // Calculate the number of days between pick-up and return dates
    $pickTimestamp = strtotime($pickDate);
    $returnTimestamp = strtotime($returnDate);
    if ($returnTimestamp > $pickTimestamp) {
        $days = floor(($returnTimestamp - $pickTimestamp) / (60 * 60 * 24));
    } else {
        exit("Error: Return date must be after pick-up date.");
    }

    // Calculate the total price
    $cout = $coutparJ * $days;
} catch (PDOException $e) {
    // Handle database errors
    exit("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="./assets/css/facturestyle.css"> <!-- Add a separate CSS file for styles -->
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div>
        <a class="navbar-brand" href="#">Tunisia Rent Cars</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rent.php">Rent a Car</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="index.html#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="facture-details">
        <h2>Facture</h2>
        <p><span>Car:</span> <span id="carName"><?= htmlspecialchars($carMarque) ?></span></p>
        <p><span>Price per day:</span> $<?= htmlspecialchars($coutparJ) ?></p>
        <p><span>Pick-up Date:</span> <span id="pickDate"><?= htmlspecialchars($pickDate) ?></span></p>
        <p><span>Return Date:</span> <span id="returnDate"><?= htmlspecialchars($returnDate) ?></span></p>
        <p><span>Location:</span> <span id="location"><?= htmlspecialchars($location) ?></span></p>
        <p><span>Total Price:</span> $<?= htmlspecialchars($cout) ?></p>
    </div>

    <!-- Pay and Cancel Buttons -->
    <div class="action-buttons">
        <button class=" btn btn-success " onclick="payer(<?= htmlspecialchars($result['id_voiture']) ?>, <?= htmlspecialchars($cout) ?>)">Pay Now</button>
        <a href="rent.php" class="btn btn-cancel">Cancel</a>
    </div>
</div>

<script>
    function payer(carId, price) {
        // Retrieve selected values
        var pickDate = "<?= htmlspecialchars($pickDate) ?>";
        var returnDate = "<?= htmlspecialchars($returnDate) ?>";
        var location = "<?= htmlspecialchars($location) ?>";

        // AJAX request to send data to PHP page for payment processing and insertion
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process_payment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle response from PHP page
                var response = xhr.responseText;
                if (response.trim() === "success") {
                    // Redirect to rent.php if payment is successful
                    window.location.href = "rent.php";
                } else {
                    // Display error message
                    alert(response);
                }
            }
        };
        // Prepare data to send
        var data = "carId=" + encodeURIComponent(carId) + "&pickDate=" + encodeURIComponent(pickDate) + "&returnDate=" + encodeURIComponent(returnDate) + "&location=" + encodeURIComponent(location) + "&clientId=" + encodeURIComponent("<?= htmlspecialchars($clientId) ?>") + "&price=" + encodeURIComponent(price);
        // Send data
        xhr.send(data);
    }
</script>

</body>
</html>
