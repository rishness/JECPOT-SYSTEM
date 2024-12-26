<?php
session_start();

// Validate if user ID is set in the session
if (!isset($_SESSION['id'])) {
    die("User not logged in."); // Or redirect to a login page
}

$user_id = $_SESSION['id'];

// Retrieve and sanitize POST inputs
$sales = isset($_POST['total_sales']) ? floatval($_POST['total_sales']) : 0;
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;

// Calculate discounted sales and payment
$discounted_sales = $sales - $discount;
$payment = $amount + $discount;

// Check if payment is sufficient
if ($payment < $sales) {
    displayErrorModal("Insufficient Amount. Please Try Again!", "../point-of-sale.php");
    exit;
}

try {
    // Database connection
    $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Begin transaction
    $db->beginTransaction();

    // Insert transaction record
    $insertSql = "INSERT INTO transaction (user_id, sales, discounted_sales, amount, created) 
                  VALUES (:user_id, :sales, :discounted_sales, :amount, NOW())";
    $insertStmt = $db->prepare($insertSql);
    $insertStmt->execute([
        ':user_id' => $user_id,
        ':sales' => $sales,
        ':discounted_sales' => $discounted_sales,
        ':amount' => $amount
    ]);

    // Update history status
    $updateSql = "UPDATE history SET status = 'success' WHERE user_id = :user_id";
    $updateStmt = $db->prepare($updateSql);
    $updateStmt->execute([':user_id' => $user_id]);

    // Check if rows were updated
    if ($updateStmt->rowCount() > 0) {
        // Commit transaction and redirect on success
        $db->commit();
        header('Location: ../success.php?sales=' . $sales . '&discount=' . $discount . '&amount=' . $amount . '&discounted_sales=' . $discounted_sales);
        exit;
    } else {
        // Rollback on failure
        $db->rollBack();
        displayErrorModal("Transaction Failed. Please Try Again!", "../point-of-sale.php");
    }
} catch (PDOException $e) {
    // Handle database exceptions
    $db->rollBack();
    error_log("Database error: " . $e->getMessage());
    displayErrorModal("An error occurred. Please try again later.", "../point-of-sale.php");
}

/**
 * Displays an error modal with a message and redirects after closing
 * @param string $message - The error message to display
 * @param string $redirectUrl - The URL to redirect to after closing the modal
 */
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
                        <h5 class="modal-title" id="errorModalLabel">Transaction Error</h5>
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
