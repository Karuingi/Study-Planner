<?php
// Include the config.php file to access the database connection variables
require_once('includes/config.php');
$manualProgress = 20;
// Calculate automatic progress (for demonstration purpose)
// Assume $userId is the user's identifier obtained from session or elsewhere
$userId = 1; // Example user ID
$query = "SELECT AVG(progress) AS average_progress FROM user_study_progress WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $automaticProgress = round($row['average_progress'], 2); // Round to 2 decimal places
} else {
    $manualProgress = 20; // If no progress data found, set progress to 0
}

// Handle file deletion
if (isset($_POST['delete_file'])) {
    $filename = $_POST['filename'];
    $filepath = 'uploads/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath); // Delete the file
        echo "<script>alert('File deleted successfully.');</script>";
    } else {
        echo "<script>alert('File not found.');</script>";
    }
}

$uploadDir = 'uploads/';

// Insert progress data into the table
if (isset($_POST['progress'])) {
    $progress = $_POST['progress'];
    $query = "INSERT INTO user_study_progress (user_id, progress) VALUES (?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("id", $userId, $progress);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Study Progress</title>
<style>
/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light gray background color */
    margin: 0;
    padding: 0;
}

/* Header styles */
.header {
    background-color: #333; /* Dark gray background color */
    color: #fff; /* White text color */
    padding: 20px;
    text-align: center;
}

/* Main content styles */
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff; /* White background color for content */
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Drop shadow effect */
}
/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0; /* Light gray background color */
    margin: 0;
    padding: 0;
    text-align: center; /* Center-align the content */
}

/* Progress bar styles */
.unit-progress {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.progress-bar-and-text {  
    display: flex;
    align-items: center;
    gap: 20px;
}

#progress-bar {
    width: 100%;
    height: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#progress {
    width: <?php echo $automaticProgress; ?>%;
    height: 100%;
    background-color: #4caf50;
    border-radius: 5px;
}

/* File list styles */
.file-list {
    margin-top: 20px;
}

.file-list ul {
    list-style-type: none;
    padding: 0;
}

.file-list li {
    margin-bottom: 10px;
}

/* Delete button styles */
.delete-btn {
    background-color: #f44336; /* Red background color */
    color: #fff; /* White text color */
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
}

.delete-btn:hover {
    background-color: #d32f2f; /* Darker red on hover */
}
</style>
</head>
<body>

<header class="header">
    <h1>Study Progress</h1>
</header>

<div class="container">
    <div class='unit-progress'>
        <h2>Progress</h2>
        <div class='progress-bar-and-text'>
            <div id="progress-bar">
                <div id="progress" data-unit-progress='<?php echo $manualProgress; ?>%'></div>
            </div>
            <span id='progress-text'><?php echo $manualProgress; ?>%</span>
        </div>
    </div>
</div>
    </div>

    <div class="file-list">
        <h2>Uploaded Files</h2>
        <ul>
            <script>
        // JavaScript code to update progress bar dynamically
document.addEventListener("DOMContentLoaded", function() {
    var progressElement = document.getElementById("progress");

    // Get the initial progress value from the data attribute
    var initialProgress = parseFloat(progressElement.getAttribute("data-unit-progress"));

    // Check if initialProgress is a valid number
    if (!isNaN(initialProgress)) {
        // Update the width of the progress bar
        progressElement.style.width = initialProgress + "%";

        // Update the progress text
        document.getElementById("progress-text").textContent = initialProgress + "%";
    } else {
        console.error("Invalid initial progress value: " + initialProgress);
    }
});
</script>
            <?php
            if (is_dir($uploadDir) && $dh = opendir($uploadDir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        echo "<li><a href='$uploadDir$file'>$file</a> 
                              <form method='POST' style='display: inline;'>
                                <input type='hidden' name='filename' value='$file'>
                                <input type='submit' name='delete_file' value='Delete' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this file?\");'>
                              </form>
                              </li>";
                    }
                }
                closedir($dh);
            } else {
                echo "<li>No files uploaded.</li>";
            }
            ?>
        </ul>
    </div>
</div>

</body>
</html>

