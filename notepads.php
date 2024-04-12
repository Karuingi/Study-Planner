<?php
session_start();
if(!isset($_SESSION['login'])){ //if login in session is not set
    header("Location:login.php");
}
  
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('includes/config.php');

// File upload handling
if(isset($_POST['submit'])) {
    // Specify the directory to store the uploaded files
    $uploadDir = 'uploads/';

    // Check if the upload directory exists, if not, create it
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Recursive directory creation
    }

    // Get the file details
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];

    // Check for upload errors
    if ($fileError === 0) {
        // Generate a unique file name to avoid overwriting existing files
        $uniqueFileName = uniqid() . '_' . $fileName;
        $targetFilePath = $uploadDir . $uniqueFileName;

        // Move the uploaded file to the desired location
        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Error: " . $fileError;
    }
}

// Note submission handling
if(isset($_POST['submit_note'])) {
    // Get note title and content from the POST request
    $note_title = $_POST['note_title'];
    $note_content = $_POST['note_content'];

    // Get user id from session
    $user_id = $_SESSION['id'];

    // Sanitize input (optional)
    $note_title = mysqli_real_escape_string($con, $note_title);
    $note_content = mysqli_real_escape_string($con, $note_content);

    // Insert note into the database
    $query = "INSERT INTO notepad (user_id, title, content, created_at) VALUES ('$user_id', '$note_title', '$note_content', NOW())"; 
    $result = mysqli_query($con, $query);
       
    if ($result) {
        echo "Note submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad</title>
    <!-- Include Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.js"></script>
    <!-- Include Quill stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.2/dist/quill.snow.css" rel="stylesheet" />
</head>
<body>
    <h1>Notepad</h1>
    
    <!-- Quill editor container -->
    <div id="editor">
        <p>Hello World!</p>
        <p>Some initial <strong>bold</strong> text</p>
        <p><br /></p>
    </div>
    
    <!-- Form to submit note -->
    <form id="noteForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- Title input -->
        <label for="note_title">Title:</label>
        <input type="text" id="note_title" name="note_title">
        <!-- Hidden input to store note content -->
        <input type="hidden" id="noteContent" name="note_content">
        <!-- Submit button -->
        <button type="submit" name="submit_note" id="submitBtn">Submit Note</button>
    </form>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        // Listen for form submission
        document.getElementById('noteForm').addEventListener('submit', function(event) {
            // Prevent the default form submission which is reload or redirect to another page
            event.preventDefault();
            
            // Get HTML content of the Quill editor
            const noteContent = document.querySelector('.ql-editor').innerHTML;
            
            // Set the value of the hidden input field to the note content
            document.getElementById('noteContent').value = noteContent;
            
            // Submit the form
            this.submit();
        });
    </script>
</body>
</html>
