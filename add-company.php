<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add company</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- added jQuery library -->
  <style>
    #save {
      margin-top: 10px;
    }
  </style>
</head>
<body>
<form id="contractForm" method="post" action="db-company.php">
  <div id="formFields">
    <div class="form-field">
      <label for="companyName[]">Company Name:</label>
      <input type="text" name="companyName[]" placeholder="Enter company name">
      <button type="button" class="removeForm">Remove</button>
    </div>
  </div>
  <button type="button" id="add">Add more</button>
  <button type="submit" id="save">Send to DB</button>
</form>

  <script>
    let formCount = 1;

    $(document).on('click', '#add', function() {
      const formFields = $('#formFields'); // changed to jQuery selector
      const newForm = $('<div>').addClass('form-field');

      newForm.html(`
        <label for="companyName${formCount}">Company Name:</label>
        <input type="text" name="companyName${formCount}" placeholder="Enter company name">
        <button type="button" class="removeForm">Remove</button>
      `);

      formFields.append(newForm);

      // Update the form number label
      formCount++;
      $('#formNumber').text(`Form ${formCount}`);
    });

    // Remove form field on click of "Remove" button
    $(document).on('click', '.removeForm', function() {
      $(this).closest('.form-field').remove();

      // Update the form number label
      formCount--;
      $('#formNumber').text(`Form ${formCount}`);
    });

    // Handle form submission
    $('#contractForm').submit(function(event) {
      event.preventDefault(); // Prevent default form submission behavior

      // Serialize the form data and send an AJAX request to db-connection.php
      $.post('db-company.php', $(this).serialize(), function(data) {
        alert(data); // Show the response message from db-connection.php
      });
    });
  </script>
</body>
</html>