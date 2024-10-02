<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Event</h2>

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

        // Fetch event data
        if (isset($_GET['id'])) {
            $eventId = intval($_GET['id']);
            $sql = "SELECT * FROM events WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $eventId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $event = $result->fetch_assoc();
            } else {
                echo "<p class='alert alert-danger'>Event not found.</p>";
                exit;
            }
        } else {
            echo "<p class='alert alert-danger'>No event ID specified.</p>";
            exit;
        }
        ?>

        <form action="update_event.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
            <div class="mb-3">
                <label for="eventName" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="eventName" name="eventName" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="eventDescription" class="form-label">Event Description</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" required><?php echo htmlspecialchars($event['event_description']); ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo htmlspecialchars($event['start_date']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo htmlspecialchars($event['end_date']); ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <select class="form-select" id="location" name="location" required>
                    <option disabled>Select a City</option>
                    <?php
                    // List of cities
                    $cities = ["Delhi", "Mumbai", "Bengaluru", "Chennai", "Kolkata", "Hyderabad", "Ahmedabad", "Pune", "Jaipur", "Surat", "Lucknow", "Kanpur", "Nagpur", "Indore", "Patna", "Bhopal", "Vadodara", "Coimbatore", "Ludhiana", "Agra"];
                    foreach ($cities as $city) {
                        $selected = ($city == $event['location']) ? "selected" : "";
                        echo "<option value='$city' $selected>$city</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="volunteersNeeded" class="form-label">Number of Volunteers Needed</label>
                <input type="number" class="form-control" id="volunteersNeeded" name="volunteersNeeded" value="<?php echo htmlspecialchars($event['volunteers_needed']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="skillsNeeded" class="form-label">Skills Needed</label>
                <select class="form-select" id="skillsNeeded" name="skillsNeeded" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="Technical" <?php if ($event['skills_needed'] == "Technical") echo "selected"; ?>>Technical</option>
                    <option value="Managerial" <?php if ($event['skills_needed'] == "Managerial") echo "selected"; ?>>Managerial</option>
                    <option value="General" <?php if ($event['skills_needed'] == "General") echo "selected"; ?>>General</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
