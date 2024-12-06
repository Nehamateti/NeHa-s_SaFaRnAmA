<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safarnama";  // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for filtering
$filterType = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'all'; // For dropdown filter
$category = isset($_GET['category']) ? $_GET['category'] : null; // For activity-specific filter

// Build the SQL query based on the parameters
$sql = "SELECT * FROM destinations";

if ($category) {
    // Filter by activity category if 'category' is set
    $sql .= " WHERE activity_category = '$category'";
} elseif ($filterType !== 'all') {
    // Otherwise, apply dropdown filter
    $sql .= " WHERE suggested_type = '$filterType'";
}

// Execute the query
$result = $conn->query($sql);

// Create an array to store the data
$destinations = [];

if ($result->num_rows > 0) {
    // Fetch data for each row
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - Safarnama</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head>
<body class="destinations-page">
    <!-- Main content section -->
    <div class="container">
        <!-- Left-aligned Text: Destinations Recommended -->
        <h1 class="destinations-header">Destinations Recommended</h1>

        <!-- Filter Section (Top-right) -->
        <div class="filter-section">
            <h3>Filter Destinations</h3>
            <form id="filter-form" method="GET" action="">
                <label for="type">Select Type:</label>
                <select id="type" name="filter_type">
                    <option value="all" <?php echo $filterType === 'all' ? 'selected' : ''; ?>>All Types</option>
                    <option value="family" <?php echo $filterType === 'family' ? 'selected' : ''; ?>>Family</option>
                    <option value="solo" <?php echo $filterType === 'solo' ? 'selected' : ''; ?>>Solo</option>
                    <option value="romantic" <?php echo $filterType === 'romantic' ? 'selected' : ''; ?>>Romantic</option>
                    <option value="friends" <?php echo $filterType === 'friends' ? 'selected' : ''; ?>>Friends</option>
                    <option value="adventure" <?php echo $filterType === 'adventure' ? 'selected' : ''; ?>>Adventure</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>

        <!-- Destinations Table -->
        <table class="destinations-table">
            <thead>
                <tr>
                    <th>Destination Name</th>
                    <th>Suggested Type</th>
                    <th>Description</th>
                    <th>Budget</th>
                    <th>Activity Category</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display destinations in table
                foreach ($destinations as $destination) {
                    echo "<tr>
                        <td>{$destination['destination_name']}</td>
                        <td>{$destination['suggested_type']}</td>
                        <td>{$destination['description']}</td>
                        <td>{$destination['budget']}</td>
                        <td>{$destination['activity_category']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
