<?php

include '../conf.php';

// Code adapted from Kumar, 2023
// Read raw input using JSON
$json = file_get_contents('php://input');
error_log("Received JSON: " . $json);
// Decode JSON
$obj = json_decode($json, true);
// End of adapted code

// Check if the JSON decoding is failed
if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON Decode Error: " . json_last_error_msg());
    // Output json error
    echo json_encode(['error' => 'Invalid JSON format: ' . json_last_error_msg()]);
    exit;
}

// Extract the data from input
$tuitionID = isset($obj['tuitionID']) ? intval($obj['tuitionID']) : 0;
$role = isset($obj['role']) ? mysqli_real_escape_string($connect, $obj['role']) : '';
$fullName = isset($obj['fullName']) ? mysqli_real_escape_string($connect, $obj['fullName']) : '';
$phoneNumber = isset($obj['phoneNumber']) ? mysqli_real_escape_string($connect, $obj['phoneNumber']) : '';
$title = isset($obj['title']) ? mysqli_real_escape_string($connect, $obj['title']) : '';
$feedback = isset($obj['feedback']) ? mysqli_real_escape_string($connect, $obj['feedback']) : '';

// Check for any missing required fields for data validation
if (empty($tuitionID) || empty($role) || empty($fullName) || empty($phoneNumber) || empty($title) || empty($feedback)) {
    echo json_encode(['error' => 'All fields are required.']);
    exit;
}

// Code adapted from Yassein, 2020
// Insert data into complaints table
$query = "INSERT INTO complaints (tuitionID, role, fullName, phoneNumber, title, feedback) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);

if ($stmt) {
    // Bind the parameters to the query
    mysqli_stmt_bind_param($stmt, 'isssss', $tuitionID, $role, $fullName, $phoneNumber, $title, $feedback);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Show message if query is successful
        echo json_encode(['message' => 'Your complaint has been submitted! We appreciate your feedback.']);
    
    } else {
        
        error_log("Database Error: " . mysqli_error($connect));
        echo json_encode(['error' => 'Database error. Please try again later.']);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    // End of adapted code

} else {
    // Error handling if the prepared statement fails
    error_log("Query Preparation Error: " . mysqli_error($connect));
    echo json_encode(['error' => 'Failed to prepare the query.']);
}

// Close the database connection
mysqli_close($connect);

?>
