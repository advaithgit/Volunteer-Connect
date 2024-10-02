<?php
// signup.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $servername = "localhost"; // Your server name
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "volunteer_connect"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate inputs
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists, redirect to login page with error
        echo "<script>
            alert('Account already exists. Please log in.');
            window.location.href = 'login.html';
        </script>";
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $hashedPassword);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the login page after successful signup
            header("Location: login.html");
            exit(); // Stop further script execution
        } else {
            echo "Error: " . $stmt->error; // Handle error
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
