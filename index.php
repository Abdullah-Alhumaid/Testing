<!DOCTYPE html>
<html>
<head>
  <title>Dynamic HTML Form</title>
  <style>
    form {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .form-field {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .form-field label {
      margin-right: 10px;
    }

    .removeForm {
      margin-right: 10px;
      order: -1;
    }

    #addForm {
      margin-top: 10px;
    }

    #saveForm {
      margin-top: 10px;
    }

    #formNumber {
      margin-top: 10px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    var formCount = 1; // Initialize form count to 1

    // Bind click event to "Add Form" button using event delegation
    $(document).on('click', '#addForm', function() {
      const formFields = document.getElementById('formFields');
      const newForm = document.createElement('div');
      newForm.classList.add('form-field');

      newForm.innerHTML = `
        <label for="contract_limit">Contract Limit:</label>
        <input type="number" name="contractLimit[]" required>
        <label for="CO_ID">Company:</label>
        <input type="number" name="CO_ID[]" required>
        <button type="button" class="removeForm">Remove</button>
      `;

      formFields.appendChild(newForm);

      // Update the form number label
      formCount++;
      document.getElementById('formNumber').innerText = `Form ${formCount}`;
    });

    // Remove form field on click of "Remove" button
    $(document).on('click', '.removeForm', function() {
      $(this).closest('.form-field').remove();

      // Update the form number label
      formCount--;
      document.getElementById('formNumber').innerText = `Form ${formCount}`;
    });

    // Handle form submission
    $('#contractForm').submit(function(event) {
      event.preventDefault(); // Prevent default form submission behavior

      // Serialize the form data and send an AJAX request to db-connection.php
      $.post('db-connection.php', $(this).serialize(), function(data) {
        alert(data); // Show the response message from db-connection.php
      });
    });
  </script>
</head>
<body>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $companyName = $_POST['company'];
    }
  ?>

  <form id="contractForm" method="post" action="db-connection.php">
    <h4 id="formNumber">Form 1</h4> <!-- Form number label -->
    <div id="formFields">
      <div class="form-field">
        <label for="contract_limit">Contract Limit:</label>
        <input type="number" name="contractLimit[]" required>
        <label for="CO_ID">Company:</label>
        <input type="number" name="CO_ID[]" required>
        <button type="button" class="removeForm">Remove</button>
      </div>
    </div>

    <button type="button" id="addForm">Add Form</button>
    <button type="submit" id="saveForm">Save</button>
  </form>
</body>
</html>