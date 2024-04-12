<?php
// Include the config.php file to access the database connection variables
require_once('includes/config.php');

// Check if the unit ID is provided
if(isset($_GET['unit_id'])) {
    $unitId = $_GET['unit_id'];
    
    // Fetch subunits based on the selected unit
    $query = "SELECT id, subunit_name FROM subunit WHERE unit_id = $unitId";
    $result = $con->query($query);

    // Check for query execution error
    if ($result) {
        $subunits = array();
        while ($row = $result->fetch_assoc()) {
            $subunits[] = $row;
        }
        echo json_encode($subunits);
    } else {
        echo "Error executing query: " . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>
