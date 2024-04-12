<?php
session_start();
if(!isset($_SESSION['login'])){ //if login in session is not set
    header("Location:login.php");
}
// Database connection parameters
include('includes/config.php');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form data is set and not empty
if(isset($_POST['notification_message']) && isset($_POST['due_date']) && isset($_POST['updated_at'])) {
    // Retrieve form data
    $user_id = $_SESSION['id']; // Assuming you have stored the user ID in the session
    $notification_message = $_POST['notification_message'];
    $due_date = $_POST['due_date'];
    $updated_at = $_POST['updated_at'];

    // Prepare SQL statement
    $sql = "INSERT INTO reminders (id, notification_message, due_date, updated_at)
            VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $user_id, $notification_message, $due_date, $updated_at);
        
        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Reminder successfully set.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }
} 
// Prepare SQL statement to select tasks with due dates that have already passed
$sql = "SELECT * FROM reminders WHERE due_date < NOW() AND notified = 0";
$result = $con->query($sql);

// Check if there are any tasks with due dates that have passed and not yet notified
if ($result->num_rows > 0) {
    // Loop through each task
    while ($row = $result->fetch_assoc()) {
        // Retrieve user information for the task
        $id = $row['id'];
        $notification_message = $row['notification_message'];
        
        // You can customize the notification method here, such as sending an email
        // For example, to send an email notification:
        // mail($user_email, 'Task Due Notification', "Your task '$task_name' is overdue!");
        
        // Alternatively, you can use a messaging service or any other preferred notification method
        
        // Update the task status to indicate that it has been notified
        $rem_id = $row['rem_id'];
        $update_sql = "UPDATE reminders SET notified = 1 WHERE rem_id = $rem_id";
        $con->query($update_sql);
    }
}

// Close connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('rent.png');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: lightcyan;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            margin: 10px 0;
            color: silver;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"],
        input[type="email"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            background-color: #dc3545;
        }
        /* Navigation bar styles */
        nav {
            background-color: #333;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        /* Panel styles */
        .panel {
            display: none;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            margin-top: 20px;
        }
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .container {
                max-width: 90%;
            }
            a:hover {
    cursor: pointer;
    color: green;
}

        }
    </style>
</head>
<body>
    <!-- Navigation bar -->
    <nav>
        <ul>
            <li><a href="index.php" style="color: red;">Find Your Way Back</a></li>
        </ul>
    </nav>
    
    <div class="container">
        <h1><b>Study Planner System</b></h1>
        <br>
        <h2>Hello, <?php echo $_SESSION['username']; ?></h2>
        <br>
        <h2><i> Set Reminders for Tasks</h2>
            <form method="post" action="reminder.php">
                <label for="notification_message">Notification Message:</label><br>
                <input type="text" id="notification_message" name="notification_message" required><br><br>
                
                <label for="due_date">Due Date:</label><br>
                <input type="date" id="due_date" name="due_date" required><br><br>
                
                <label for="updated_at">Updated At:</label><br>
                <input type="datetime-local" id="updated_at" name="updated_at" required><br><br>
                
                <button type="submit" name="submit">Add Reminder</button>
            </form>
        
    <script>
        // Function to toggle profile panel visibility
        document.getElementById('show-profile').addEventListener('click', function() {
            var panel = document.getElementById('profile-panel');
            if (panel.style.display === 'none') {
                panel.style.display = 'block';
            } else {
                panel.style.display = 'none';
            }
        });
    </script>
</body>
</html>

