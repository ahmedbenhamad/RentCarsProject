<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 15px;
        }

        li a {
            display: block;
            padding: 15px;
            background-color: #007bff;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        li a:hover {
            background-color: #0056b3;
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .logout a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome to Control Panel</h2>
    <ul>
        <li><a href="usersList.php">Users List</a></li>
        <li><a href="addCar.php">Add Car</a></li>
        <li><a href="updateCar.php">Update Car</a></li>
        <li><a href="list_cars.php">List Cars</a></li>
    </ul>
    <div class="logout">
        <a href="admin.php">Logout</a>
    </div>
</div>
</body>
</html>

