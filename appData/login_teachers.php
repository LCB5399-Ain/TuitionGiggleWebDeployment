<?php

// Centralized the database connection setup
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

// Disable the error reporting in the JSON responses
error_reporting(0);
ini_set('display_errors', 0);

// Set the database parameters
$host = "mysql-10a0243e-haziqimac-894f.e.aivencloud.com";
$username = "avnadmin";
$password = "AVNS_eLMssnTB234OoLL-_Fk";
$database = "defaultdb";
$port = 25615;

// New database connection
$connect = new mysqli($host, $username, $password, $database, $port);

// Check for connection errors
if ($connect->connect_error) {
    // Output the connection error
    echo json_encode(['error' => "Connection Failed: " . $connect->connect_error]);
    exit(); // Stop execution if the connection fails
}

?> 