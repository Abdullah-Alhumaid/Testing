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

// Prepare and bind the SELECT statement to check for existing company_name
$selectStmt = $conn->prepare("SELECT company_name FROM companies WHERE company_name = ?");
if (!$selectStmt) {
    die("Error preparing statement: " . $conn->error);
}

// Prepare and bind the INSERT statement
$insertStmt = $conn->prepare("INSERT INTO companies (company_name) VALUES (?)");
if (!$insertStmt) {
    die("Error preparing statement: " . $conn->error);
}

// Insert the data for each company name submitted
$companyNames = $_POST['companyName'];
$insertCount = 0; // keep track of the number of successful insertions
$failedNames = array(); // keep track of the company names that failed to insert
$successNames = array(); // keep track of the company names that were successfully inserted
foreach ($companyNames as $companyName) {
    $companyName = trim($companyName);
    if (!empty($companyName)) { // ensure the value is not empty or whitespace-only
        // Check if company_name already exists in the database
        $selectStmt->bind_param("s", $companyName);
        if (!$selectStmt->execute()) {
            die("Error checking for existing data: " . $conn->error);
        }
        $result = $selectStmt->get_result();
        if ($result->num_rows > 0) {
            $failedNames[] = $companyName; // add the company name to the failed names array
        } else {
            // Insert the data if company_name does not already exist in the database
            $insertStmt->bind_param("s", $companyName);
            if (!$insertStmt->execute()) {
                die("Error inserting data: " . $conn->error);
            }
            $insertCount++; // increment the successful insertions count
            $successNames[] = $companyName; // add the company name to the success names array
        }
    }
}

// Close the statements and connection
$selectStmt->close();
$insertStmt->close();
$conn->close();

// Display success or failure message
if (!empty($failedNames)) {
    $failedNamesStr = implode(", ", $failedNames);
    $successNamesStr = implode(", ", $successNames);
    echo "Company name(s) '$failedNamesStr' already exist(s) in the database, but '$successNamesStr' was inserted successfully.";
} else if ($insertCount == 0) {
    echo "No data inserted";
} else if ($insertCount == 1) {
    echo "1 record inserted successfully";
} else {
    echo "$insertCount records inserted successfully";
}