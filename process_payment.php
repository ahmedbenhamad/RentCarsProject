<?php
session_start();
require_once 'conf.php';

// Check if the required POST parameters are set
if (isset($_POST['carId'], $_POST['pickDate'], $_POST['returnDate'], $_POST['location'], $_POST['clientId'], $_POST['price'])) {
    $carId = $_POST['carId'];
    $pickDate = $_POST['pickDate'];
    $returnDate = $_POST['returnDate'];
    $location = $_POST['location'];
    $clientId = $_POST['clientId'];
    $price = $_POST['price'];

    try {
        // Establish a connection to the database using PDO
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
        // Configure PDO if necessary
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL query to insert rental data into the location table
        $stmt = $pdo->prepare("INSERT INTO location (id_vehicule, id_client, date_debut, date_fin, ville_reservation, cout_total) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$carId, $clientId, $pickDate, $returnDate, $location, $price]);

        // Send a success response
        echo "Car rented successfully!";


    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Required parameters are missing!";
}

