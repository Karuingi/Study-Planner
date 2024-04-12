<?php
session_start();
// Database connection parameters
include('includes/config.php');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve user ID from session
$id = $_SESSION['id'];

// Prepare SQL statement to select expired reminders
$sql = "SELECT * FROM reminders WHERE id = ? AND due_date < CURRENT_DATE";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch expired reminders as JSON data
$expired_reminders = array();
while ($row = $result->fetch_assoc()) {
    $expired_reminders[] = $row;
}

// Close statement and connection
$stmt->close();
$con->close();

// Return expired reminders as JSON
echo json_encode($expired_reminders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Notifications</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script> <!-- Include your JavaScript file -->
</head>
<body>
    <!-- Notification section (if needed) -->
</body>
</html>
