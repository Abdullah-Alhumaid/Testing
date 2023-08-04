<?php

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind the INSERT statement
$stmt = $conn->prepare("INSERT INTO companies (company_name) VALUES (?)");
$stmt->bind_param("s", $companyName);

// Insert the data for each company name submitted
$companyNames = $_POST['companyName'];
foreach ($companyNames as $companyName) {
    if (trim($companyName) !== '') { // ensure the value is not empty or whitespace-only
        $stmt->execute();
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

echo "Data inserted successfully";