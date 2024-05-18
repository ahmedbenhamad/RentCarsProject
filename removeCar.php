<?php
// Remove user script
require_once "conf.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the POST request
    $CarId = $_POST['id'];

    // Perform database operation to remove the user with the given ID
    // Example:
    try {
        $conn = new PDO(DB_DSN, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql="DELETE FROM voiture WHERE id_voiture = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $CarId);
        $result=$stmt->execute();
        http_response_code(200);
        echo "<script>alert('the user has been removed');</script>";

    } catch (PDOException $e) {
        // Handle database errors
        http_response_code(500);
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Handle invalid requests
    http_response_code(400);
    echo 'Bad Request';
}
?>

