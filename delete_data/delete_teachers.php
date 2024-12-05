<?php

require_once "../dbconf.php";

// Check if teacherID is provided
if (isset($_GET['teacherID']) && is_numeric($_GET['teacherID'])) {
    $teacherID = (int)$_GET['teacherID'];

    // Check if the teacher is referenced in the class table
    $dependencyCheckQuery = "SELECT COUNT(*) AS count FROM class WHERE teacherID = ?";
    $stmtCheck = $link->prepare($dependencyCheckQuery);

    if ($stmtCheck === false) {
        echo "Error: Unable to prepare dependency check statement.";
        exit;
    }

    $stmtCheck->bind_param("i", $teacherID);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $dependency = $resultCheck->fetch_assoc();

    if ($dependency['count'] > 0) {
        // If the teacher is referenced in the class table, provide a proper error message
        echo "<script>
        alert('Error: Unable to delete teacher. This teacher is assigned to a class.');
        window.location.href='../display_data/search_teachers.php';
        </script>";

    } else {

        // Delete the teacher
        $query = "DELETE FROM teachers WHERE teacherID = ?";
        $stmt = $link->prepare($query);

        if ($stmt === false) {
            echo "Error: Unable to prepare statement.";
            exit;
        }

        // Bind the teacherID and execute the query
        $stmt->bind_param("i", $teacherID);

        if ($stmt->execute()) {
            echo "<script>
            alert('Teacher has been successfully deleted');
            window.location.href='../display_data/search_teachers.php';
            </script>";
        } else {
            // Display the error message
            echo "Error: Unable to delete teacher: " . $stmt->error;
        }

        // Close the delete statement
        $stmt->close();
    }

    $stmtCheck->close();

} else {
    echo "Invalid teacher ID";
}

$link->close();

?>
