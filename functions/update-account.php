<?php

// Get the user ID from the hidden input field.
$user_id = $_POST['userid'];

// Connect to the database.
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Get the current password from the database.
$sql = "SELECT password FROM users WHERE id = :user_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$row = $stmt->fetch();
$current_password = $row['password'];

// Check if the current password is correct.
if (password_verify($_POST['password'], $current_password)) {

  // Hash the new password.
  $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

  // Update the password in the database.
  $sql = "UPDATE users SET password = :new_password WHERE ID = :user_id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':new_password', $new_password);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();

  // Redirect the user to the main page.
  header('Location: ../users.php');
  exit;

} else {
  // Display the error modal when the current password is incorrect
  displayErrorModal("The entered old password is incorrect. Please try again.", "../users.php");
}
  
// Function to display the error modal
function displayErrorModal($message, $redirectUrl)
{
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <title>Error</title>
    </head>
    <body>
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Password Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>' . htmlspecialchars($message) . '</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Automatically show the modal after page load
            window.onload = function() {
                var errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
                errorModal.show();

                // Redirect after the modal is closed
                document.getElementById("errorModal").addEventListener("hidden.bs.modal", function () {
                    window.location.href = "' . $redirectUrl . '";
                });
            };
        </script>
    </body>
    </html>
    ';
    exit;
}
?>
