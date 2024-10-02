<?php
// Database connection
$host = 'localhost';
$dbname = 'volunteer_connect';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$eventName = $_POST['eventName'];
$eventDescription = $_POST['eventDescription'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$location = $_POST['location'];
$volunteersNeeded = $_POST['volunteersNeeded'];
$skillsNeeded = $_POST['skillsNeeded'];

// Insert event into the database
$sql = "INSERT INTO events (event_name, event_description, start_date, end_date, location, volunteers_needed, skills_needed)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssis", $eventName, $eventDescription, $startDate, $endDate, $location, $volunteersNeeded, $skillsNeeded);

if ($stmt->execute()) {
    echo "Event created successfully!";
    header("Location: listing.php"); // Redirect to listing page                             *************
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
