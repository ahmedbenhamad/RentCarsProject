<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <!-- Link your CSS file here -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Add any necessary favicon -->
    <link rel="shortcut icon" type="image/icon" href="./assets/img/favicon.ico">
    <style>
        /* Additional styles specific to the view users page */
        /* Adjustments can be made as needed */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .user-table th {
            background-color: #f2f2f2;
        }

        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .user-table tr:hover {
            background-color: #ddd;
        }

        .btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
        }

        .btn-remove {
            background-color: #f44336;
            color: white;
        }

        .btn-update {
            background-color: #4CAF50;
            color: white;
        }
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
    <h2>Users List</h2>
    <div class="navbar">
        <div class="container navbar-container">
            <a href="#" class="navbar-brand">Users List</a>
            <ul class="navbar-nav">
                <li><a href="control_panel.php">Control Panel</a></li>
            </ul>
        </div>
    </div>

<!-- User List -->
<div class="user-list-container">
    <h2>User List</h2>
    <table class="user-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Actions</th> <!-- New column for actions -->
            <!-- Add more columns as needed -->
        </tr>
        </thead>
        <tbody>
        <!-- PHP code to fetch and display user data -->
        <?php
        // Sample PHP code to fetch and display user data

        session_start();
        require_once 'conf.php';

        try {
            // Establish a connection to the database using PDO
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
            // Configure PDO if necessary
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL query to fetch user data from the database
            $stmt = $pdo->query("SELECT * FROM clients");
            // Fetch all rows as an associative array
            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through each client and display their details
            foreach ($clients as $client) {
                echo "<tr>";
                echo "<td>{$client['id']}</td>";
                echo "<td>{$client['name']}</td>";
                echo "<td>{$client['age']}</td>";
                echo "<td>{$client['email']}</td>";
                // Add buttons for removing and updating user information
                echo "<td>";
                echo "<button class='btn btn-remove' onclick='removeUser({$client['id']})'>Remove</button>";

                echo "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
        ?>
        </tbody>
    </table>
</div>

<!-- JavaScript for handling button actions -->
<script>
    // Function to remove user
    function removeUser(userId) {
        if (confirm('Are you sure you want to remove this user?')) {
            // Send AJAX request to remove user
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'removeuser.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Remove the user row from the table
                    document.getElementById('userRow_' + userId).remove();
                    alert('User removed successfully');
                } else {
                    // Handle errors
                    alert('Error: ' + xhr.responseText);
                }
            };
            xhr.send('id=' + userId);
        }
    }


</script>
</body>
</html>
