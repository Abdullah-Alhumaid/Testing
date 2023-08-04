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

// Fetch the company names from the database
$sql = "SELECT company_name FROM companies";
$result = $conn->query($sql);

$companies = array();

if ($result->num_rows > 0) {
  // Loop through the result set and add each company name to the array
  while($row = $result->fetch_assoc()) {
    array_push($companies, $row['company_name']);
  }
}

// Close the database connection
$conn->close();

// Return the company names as a JSON-encoded array
echo json_encode($companies);
?>