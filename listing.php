<?php
// Database connection
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "volunteer_connect"; // Change if necessary

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch events from the database
$sql = "SELECT * FROM events"; // 'events' should be the table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .card-img-top {
        width: 100%;
        height: 200px; /* Set a fixed height to ensure uniformity */
        object-fit: cover; /* Ensures the image covers the area without distortion */
    }

    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Adds a shadow for a uniform look */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-text {
        min-height: 60px; /* Ensures the text area remains consistent */
    }

    .perk-badge {
        background-color: #28a745;
        color: white;
        padding: 0.2em 0.6em;
        border-radius: 10px;
        font-size: 0.8em;
    }

    .sidebar {
        display: none;
    }

    @media (min-width: 768px) {
        .sidebar {
            display: block;
        }
    }

    .btn-link {
        text-decoration: none; /* Removes underline */
        color: inherit; /* Inherits the color from the parent button */
    }
</style>

</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Volunteer Connect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="./index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="./index.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
                <form class="d-flex me-2">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/30" alt="Profile" class="rounded-circle"> User
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="./profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="./index.html">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
    <div class="row">
        <!-- Sidebar (Collapsible) -->
        <button class="btn btn-secondary d-md-none mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
            ☰ Filters
        </button>
        <nav id="sidebarCollapse" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Post new Event</span>
                </h5>
                <form method="GET" action="">
                    <div class="mb-3">
                        <button class="btn btn-primary mt-3">
                            <a href="create_event.html" class="btn-link" style="color: white; text-decoration: none;">Create Event</a>
                        </button>
                    </div>
                    <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Filters</span>
                    </h5>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <select class="form-select" name="dateFilter">
                            <option selected>Choose...</option>
                            <option value="this_week">This week</option>
                            <option value="fortnight">Fortnight</option>
                            <option value="this_month">This Month</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="technical" name="skills[]" id="technicalSkills">
                            <label class="form-check-label" for="technicalSkills">Technical Skills</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="general" name="skills[]" id="generalSkills">
                            <label class="form-check-label" for="generalSkills">General Skills</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="managerial" name="skills[]" id="managerialSkills">
                            <label class="form-check-label" for="managerialSkills">Managerial Skills</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="locationFilter" class="form-label">Location</label>
                        <select class="form-select" id="locationFilter" name="locationFilter">
                            <option selected disabled>Select a City</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Bengaluru">Bengaluru</option>
                            <option value="Chennai">Chennai</option>
                            <option value="Kolkata">Kolkata</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="Ahmedabad">Ahmedabad</option>
                            <option value="Pune">Pune</option>
                            <option value="Jaipur">Jaipur</option>
                            <option value="Surat">Surat</option>
                            <option value="Lucknow">Lucknow</option>
                            <option value="Kanpur">Kanpur</option>
                            <option value="Nagpur">Nagpur</option>
                            <option value="Indore">Indore</option>
                            <option value="Patna">Patna</option>
                            <option value="Bhopal">Bhopal</option>
                            <option value="Vadodara">Vadodara</option>
                            <option value="Coimbatore">Coimbatore</option>
                            <option value="Ludhiana">Ludhiana</option>
                            <option value="Agra">Agra</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
                </form>
            </div>
        </nav>

<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3">
        <h3>Posted Events</h3>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        <?php
        // Initialize filter variables
        $dateFilter = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '';
        $locationFilter = isset($_GET['locationFilter']) ? $_GET['locationFilter'] : '';
        $skillsFilter = isset($_GET['skills']) ? $_GET['skills'] : [];

        // Prepare SQL query with filters
        $query = "SELECT * FROM events WHERE 1=1";

        if ($dateFilter) {
            // Add date filtering logic
            switch ($dateFilter) {
                case 'this_week':
                    $query .= " AND start_date >= CURDATE() AND start_date < CURDATE() + INTERVAL 7 DAY";
                    break;
                case 'fortnight':
                    $query .= " AND start_date >= CURDATE() AND start_date < CURDATE() + INTERVAL 14 DAY";
                    break;
                case 'this_month':
                    $query .= " AND MONTH(start_date) = MONTH(CURDATE()) AND YEAR(start_date) = YEAR(CURDATE())";
                    break;
            }
        }

        if ($locationFilter) {
            $query .= " AND location = '" . $conn->real_escape_string($locationFilter) . "'";
        }

        if (!empty($skillsFilter)) {
            $skillsCondition = [];
            foreach ($skillsFilter as $skill) {
                $skillsCondition[] = "skills_needed LIKE '%" . $conn->real_escape_string($skill) . "%'";
            }
            if ($skillsCondition) {
                $query .= " AND (" . implode(" OR ", $skillsCondition) . ")";
            }
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Output data for each event
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col">';
                echo '  <div class="card h-100">';

                // Determine which image to show based on the 'skills_needed' field
                $skills = !empty($row['skills_needed']) ? strtolower($row['skills_needed']) : 'N/A';
                if (strpos($skills, 'technical') !== false) {
                    $eventImage = 'pic1.jpg';
                } elseif (strpos($skills, 'general') !== false) {
                    $eventImage = 'CHILDREN.jpg';
                } elseif (strpos($skills, 'managerial') !== false) {
                    $eventImage = 'pic3.jpg';
                } else {
                    $eventImage = 'volunteers.jpg'; // Fallback image
                }

                echo '      <img src="' . $eventImage . '" class="card-img-top" alt="Event Image">';
                echo '      <div class="card-body">';
                echo '          <h5 class="card-title"><a href="./orgprof2.html" class="btn-link">' . htmlspecialchars($row['event_name'] ?? 'N/A') . '</a></h5>';

                // Check for description
                $description = !empty($row['event_description']) ? htmlspecialchars($row['event_description']) : 'No description available.';
                echo '          <p class="card-text">' . $description . '</p>';

                // Display start and end date
                echo '          <p><strong>Date:</strong> ' . htmlspecialchars($row['start_date'] ?? 'N/A') . ' to ' . htmlspecialchars($row['end_date'] ?? 'N/A') . '</p>';

                // Display location
                echo '          <p><strong>Location:</strong> ' . htmlspecialchars($row['location'] ?? 'N/A') . '</p>';

                // Display volunteers needed
                echo '          <p><strong>Volunteers Needed:</strong> ' . htmlspecialchars($row['volunteers_needed'] ?? 'N/A') . '</p>';

                // Display skills needed
                echo '          <p><strong>Skills Needed:</strong> ' . htmlspecialchars($row['skills_needed'] ?? 'N/A') . '</p>';

                // Buttons (Edit and Delete)
                echo '          <div class="d-flex justify-content-start">';

                // Edit button (Styled in blue, same size as delete)
                echo '          <a href="edit_event.php?id=' . $row['id'] . '" class="btn btn-primary me-2">Edit</a>';

                // Delete button (Form)
                echo '          <form method="POST" action="" class="m-0">'; // Added m-0 to remove margin
                echo '              <input type="hidden" name="event_id" value="' . $row['id'] . '">';
                echo '              <button type="submit" name="delete_event" class="btn btn-danger">Delete</button>';
                echo '          </form>';

                echo '          </div>'; // End of buttons div

                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p>No events found.</p>';
        }

        // Handle event deletion
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_event'])) {
            $eventId = intval($_POST['event_id']);
            $deleteQuery = "DELETE FROM events WHERE id = $eventId";

            if ($conn->query($deleteQuery) === TRUE) {
                echo '<p class="alert alert-success">Event deleted successfully.</p>';
                // Refresh the page to show updated events list
                echo '<script>window.location.reload();</script>';
            } else {
                echo '<p class="alert alert-danger">Error deleting event: ' . $conn->error . '</p>';
            }
        }
        ?>
    </div>
</main>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function resetFilters() {
        window.location.href = window.location.pathname; // Redirect to the same page without any filters
    }
</script>
</body>
</html>

<?php
$conn->close();
?>
