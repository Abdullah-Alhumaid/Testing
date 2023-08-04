<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface</title>
</head>
<body>
    <h4>Which company you want to generate a contract for:</h4>
    <form action="index.php" method="post">
        <select name="company" id="company">
        <?php
            // Connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "coop";
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the companies from the database
            $sql = "SELECT Companies_ID, Company_name FROM companies";
            $result = $conn->query($sql);

            // Add each company as an option in the select element
            while($row = $result->fetch_assoc()) {
                echo "<option value='{$row['Companies_ID']}'>{$row['Company_name']}</option>";
            }

            // Close the database connection
            $conn->close();
        ?>
        </select>
        <button type="submit">Go</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('change', '#company', function() {
            const companyId = $(this).val();
            $('input[name="CO_ID[]"]').val(companyId);
        });
    </script>
</body>
</html>