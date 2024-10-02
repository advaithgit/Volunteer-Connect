<?php
// login.php

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // default password is empty for XAMPP
$dbname = "volunteer_connect"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, now verify the password
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            session_start(); // Start session if you want to use session variables
            $_SESSION['username'] = $username; // Store username in session
            header("Location: listing.php"); // Redirect to listing page                           **************
            exit();
        } else {
            // Invalid password
            header("Location: login.html?error=" . urlencode("Invalid password."));
            exit();
        }
    } else {
        // No user found
        header("Location: login.html?error=" . urlencode("No user found with that username."));
        exit();
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
