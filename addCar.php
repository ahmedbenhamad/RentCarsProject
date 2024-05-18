<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter voiture</title>
    <link rel="stylesheet" href="./assets/css/signupstyle.css">
    <link rel="shortcut icon" type="image/icon" href="./assets/img/clients/icon.ico">
    <style>
    /* Paste the provided CSS styles here */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000; /* Ensure it appears above other elements */
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
<div class="signup-container">
    <h2>Ajouter voiture</h2>
    <div class="navbar">
        <div class="container navbar-container">
            <a href="#" class="navbar-brand">Ajouter voiture</a>
            <ul class="navbar-nav">
                <li><a href="control_panel.php">Control Panel</a></li>
            </ul>
        </div>
    </div>
    <form action="addCar.php" method="POST" enctype="multipart/form-data"> <!-- Added enctype attribute for file upload -->
        <div class="form-group">
            <label for="name">marque</label>
            <input type="text" id="marque" name="marque" required>
        </div>
        <div class="form-group">
            <label for="email">modele:</label>
            <input type="text" id="modele" name="modele" required>
        </div>
        <div class="form-group">
            <label for="cin">matricule :</label>
            <input type="text" id="matricule" name="matricule" required>
        </div>
        <div class="form-group">
            <label for="telephone">annee de fabrication:</label>
            <input type="number" id="anneeF" name="anneeF" required>
        </div>
        <div class="form-group">
            <label for="age">couleur:</label>
            <input type="text" id="couleur" name="couleur" required>
        </div>
        <div class="form-group">
            <label for="prj">prix par jour:</label>
            <input type="text" id="prj" name="prj" required>
        </div>
        <div class="form-group"> <!-- Fixed closing angle bracket -->
            <label for="car_image">Image voiture:</label>
            <input type="file" id="car_image" name="car_image" accept="image/*" required>
        </div>
        <div id="error-message"></div>
        <button type="submit">Ajouter</button>
    </form>
</div>
</body>
</html>



<?php
session_start();
require_once("./conf.php");

function testinput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque = testinput($_POST["marque"]);
    $modele = testinput($_POST["modele"]);
    $matricule = testinput($_POST["matricule"]);
    $couleur = testinput($_POST["couleur"]);
    $anneF = testinput($_POST["anneeF"]);
    $prj = testinput($_POST["prj"]);
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
    // File upload handling
    if ($_FILES['car_image']['name']) {
        // Create the folder if it doesn't exist
        $target_dir = "./assets/img/clients/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the folder recursively
        }

        // Proceed with file upload
        $target_file = $target_dir . basename($_FILES["car_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["car_image"]["tmp_name"]);
        if ($check === false) {
            echo '<div class="alert alert-danger" role="alert">File is not an image.</div>';
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo '<div class="alert alert-danger" role="alert">Sorry, file already exists.</div>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["car_image"]["size"] > 500000) {
            echo '<div class="alert alert-danger" role="alert">Sorry, your file is too large.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_formats = ["jpg", "png", "jpeg", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            echo '<div class="alert alert-danger" role="alert">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($_FILES['car_image']['error'] !== UPLOAD_ERR_OK) {
            echo '<div class="alert alert-danger" role="alert">Sorry, there was an error uploading your file.</div>';
            exit;
        }

        // Attempt to move the uploaded file to the target directory
        if ($uploadOk == 1 && move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
            $uploaded_file_path = $target_dir . basename($_FILES["car_image"]["name"]);
            echo '<div class="alert alert-success" role="alert">The file ' . htmlspecialchars($uploaded_file_path) . ' has been uploaded.</div>';
        }
    }

    try {
        $conn = new PDO($dsn, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO voiture (matricule, marque, modele, annee_de_fabrication, couleur, prix_par_jour) 
                VALUES (:matricule, :marque, :modele, :anneeF, :couleur, :prj)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':matricule', $matricule);
        $stmt->bindParam(':modele', $modele);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':anneeF', $anneF);
        $stmt->bindParam(':couleur', $couleur);
        $stmt->bindParam(':prj', $prj);

        $stmt->execute();
        $vid = $conn->lastInsertId();
        echo $vid;
        $sql2 = "INSERT INTO voiture_images (voiture_id, image_name, image_path, upload_timestamp) 
                VALUES (:vid, :imgN, :imgP, :upS)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(":vid", $vid);
        $stmt2->bindParam(":imgN", $_FILES["car_image"]["name"]);
        $stmt2->bindParam(":imgP", $target_file);
        $stmt2->bindValue(":upS", date('Y-m-d H:i:s'));
        $stmt2->execute();
        echo "<script>alert('the car has been added');window.location.href='./control_panel.php';</script>";

    } catch (PDOException $e) {
        echo "<script>document.getElementById('error-message').innerHTML = 'Error: " . $e->getMessage() . "';</script>";
    }
}
?>
