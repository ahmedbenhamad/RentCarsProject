<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Update Car</h1>
    <?php
    require_once 'conf.php';
    session_start();

    // Check if the car ID is set in the URL
    if (isset($_GET['id'])) {
        $carId = $_GET['id'];

        try {
            // Establish a connection to the database using PDO
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marque']) && isset($_POST['prix_par_jour'])) {
                // Prepare the SQL query to update car details
                $sql = "UPDATE voiture SET marque = :marque, prix_par_jour = :prix_par_jour WHERE id_voiture = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':marque', $_POST['marque']);
                $stmt->bindParam(':prix_par_jour', $_POST['prix_par_jour']);
                $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                $stmt->execute();

                // Redirect to the cars list page with the car ID in the URL
                header("Location: list_cars.php");
                exit();
            }

            // Prepare the SQL query to fetch car details by ID
            $stmt = $pdo->prepare("SELECT * FROM voiture WHERE id_voiture = :id");
            $stmt->bindParam(':id', $carId, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the car details as an associative array
            $car = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($car) {
                // Display the form with existing car details
                ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id_voiture']); ?>">
                    <div class="mb-3">
                        <label class="form-label">Marque</label>
                        <input type="text" class="form-control" name="marque" value="<?php echo htmlspecialchars($car['marque']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price per day</label>
                        <input type="text" class="form-control" name="prix_par_jour" value="<?php echo htmlspecialchars($car['prix_par_jour']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Car</button>
                </form>
                <?php
            } else {
                echo "<div class='alert alert-danger'>Car not found.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Car ID not provided.</div>";
    }
    ?>
</div>
</body>
</html>
