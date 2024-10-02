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
$eventId = $_POST['event_id'];
$eventName = $_POST['eventName'];
$eventDescription = $_POST['eventDescription'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$location = $_POST['location'];
$volunteersNeeded = $_POST['volunteersNeeded'];
$skillsNeeded = $_POST['skillsNeeded'];

// Update event in the database
$sql = "UPDATE events SET event_name=?, event_description=?, start_date=?, end_date=?, location=?, volunteers_needed=?, skills_needed=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssisi", $eventName, $eventDescription, $startDate, $endDate, $location, $volunteersNeeded, $skillsNeeded, $eventId);

if ($stmt->execute()) {
    echo "Event updated successfully!";
    header("Location: listing.php"); // Redirect to listing page
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
