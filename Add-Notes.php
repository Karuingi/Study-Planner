<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
    <style>
        .code-container {
            background-color: #f5f5f5; /* Light gray background */
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .code-header {
            background-color: blueviolet; /* Dark gray background */
            color: #fff; /* White text color */
            padding: 10px 20px;
            border-top-left-radius: 15px;
            border-top-right-radius: 5px;
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="code-container">
    <h2 class="code-header">Add Notes</h2>
	<style>
.form-container {
    width: 70%;
}

.form-group {
    margin-bottom: 10px;
}

.submit-button-container {
    text-align: right;
}

.submit-button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: green;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #45a049;
}

.success-message {
    color: green;
}

.error-message {
    color: red;
}
</style>
	

<?php
// Include the config.php file to access the database connection variables
require_once('includes/config.php');

// Check if the form is submitted
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];

        // Specify the directory to store the uploaded files
        $uploadDir = 'uploads/';

        // Generate a unique file name to avoid collisions
        $uniqueFileName = uniqid() . '_' . $fileName;
        $filePath = $uploadDir . $uniqueFileName;

		// Check if the file upload was successful
		if (move_uploaded_file($fileTmpName, $uploadDir . $uniqueFileName)) {
			// File uploaded successfully, proceed with database insertion
			$query = "INSERT INTO files (unit_id, subunit_id, filename, file_path) VALUES (?, ?, ?, ?)";
			// Prepare the SQL statement
			$stmt = $con->prepare($query);
			if ($stmt) {
				// Bind parameters
				$stmt->bind_param("iiss", $unitId, $subunitId, $fileName,  $filePath);
				// Execute the query
				if ($stmt->execute()) {
					// Record inserted successfully
					echo "File uploaded successfully and record inserted into the database!";
				} else {
					// Error inserting record into the database
					echo "Error inserting record into the database: " . $stmt->error;
				}
				// Close the prepared statement
				$stmt->close();
			} else {
				// Error in preparing the statement
				echo "Error preparing statement: " . $con->error;
			}
		} else {
			// Error uploading file
			echo "Error uploading file.";
		}
	}
	
    }

// Fetch units and their related subunits
$query = "SELECT c.unit_id, c.unitName, s.id, s.subunit_name
          FROM category c
          LEFT JOIN subunit s ON c.unit_id = s.unit_id";
$result = $con->query($query);

// Check for query execution error
if (!$result) {
    echo "Error executing query: " . $con->error;
    exit;
}
?>

<!-- HTML Form -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#unit').change(function(){
                var unitId = $(this).val();
                $.ajax({
                    url: 'get_subunits.php',
                    type: 'GET',
                    data: {unit_id: unitId},
                    dataType: 'json',
                    success:function(response){
                        var len = response.length;
                        $('#subunit').empty();
                        $('#subunit').append("<option value=''>-- Select Subunit --</option>");
                        for( var i = 0; i<len; i++){
                            var id = response[i]['id'];
                            var name = response[i]['subunit_name'];
                            $('#subunit').append("<option value='"+id+"'>"+name+"</option>");
                        }
                    }
                });
            });
        });
    </script>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div style="display: inline-block; width: 70%;">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <label for="unit">Select Unit:</label>
    <select name="unit" id="unit">
        <option value="">-- Select Unit --</option>
        <?php
        // Populate units in the dropdown
        if ($result->num_rows > 0) {
            $units = [];
            while ($row = $result->fetch_assoc()) {
                $unitId = $row["unit_id"];
                if (!isset($units[$unitId])) {
                    $units[$unitId] = $row["unitName"];
                    echo '<option value="' . $unitId . '">' . $row["unitName"] . '</option>';
                }
            }
        }
        ?>
    </select>
    <br>
	<br>
    <label for="subunit">Select Subunit:</label>
    <select name="subunit" id="subunit">
        <option value="">-- Select Subunit --</option>
        <?php
        // Fetch subunits based on the selected unit
        if (isset($_POST['unit']) && !empty($_POST['unit'])) {
            $selectedUnitId = $_POST['unit'];
            $result->data_seek(0); // Reset the result pointer
            while ($row = $result->fetch_assoc()) {
                if ($row["unit_id"] == $selectedUnitId) {
                    echo '<option value="' . $row["id"] . '">' . $row["subunit_name"] . '</option>';
                }
            }
        }
        ?>
    </select>
    <br>
	<br>
    <label for="file">Select File:</label>
    <input type="file" name="file" id="file">
    <br><br>
    <input type="submit" value="Submit">
    <br><br>
    <style>
    .go-back-button {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .go-back-button:hover {
        background-color: #0056b3;
    }
</style>

    <a href="index.php" class="btn btn-secondary">Home</a>
    <br><br><br><br><br><br>
</form>

<?php
// Display success or error message if set
if (isset($successMessage)) {
    echo '<p style="color: green;">' . $successMessage . '</p>';
} elseif (isset($errorMessage)) {
    echo '<p style="color: red;">' . $errorMessage . '</p>';
}

include('include/footer.php'); ?>

	
<?php
$con->close();
?>
