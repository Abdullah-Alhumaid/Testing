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

// Retrieve form data
$contractLimits = $_POST['contractLimit'];
$companyIds = $_POST['CO_ID'];
// Loop through the form data and insert each set of data into the database
for ($i = 0; $i < count($contractLimits); $i++) {
    $contractLimit = (int)$contractLimits[$i];

    // Check if the $companyIds array has at least $i+1 elements
    if (isset($companyIds[$i])) {
        $companyId = mysqli_real_escape_string($conn, $companyIds[$i]);

        // Check if the company ID exists in the companies table
        $companyCheck = $conn->prepare("SELECT * FROM companies WHERE companies_ID = ?");
        $companyCheck->bind_param("s", $companyId);
        $companyCheck->execute();
        $companyResult = $companyCheck->get_result();

        if ($companyResult->num_rows === 0) {
            echo "Error: Company ID $companyId does not exist";
        } else {
            // Prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO contracts (contract_limit, CO_ID) VALUES (?, ?)");
            $stmt->bind_param("ds", $contractLimit, $companyId);

            // Execute SQL statement
            if ($stmt->execute()) {
                echo "Data inserted successfully ";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }

        // Close the company check statement
        $companyCheck->close();
    }
}

// Close the database connection
$conn->close();
?>