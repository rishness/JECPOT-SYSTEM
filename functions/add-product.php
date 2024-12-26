<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

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
                        <h5 class="modal-title" id="errorModalLabel">Product Error</h5>
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

// Get the form data
$product_name = $_POST['product_name'];
$qty = $_POST['qty'];
$price = $_POST['price'];

// Check if the product already exists in the database
$sql = "SELECT * FROM products WHERE product_name = :product_name";
$stmt = $db->prepare($sql);
$stmt->bindParam(':product_name', $product_name);
$stmt->execute();
$results = $stmt->fetchAll();

// If the product already exists, show the error modal
if (count($results) > 0) {
    displayErrorModal("Product already exists. Please try again!", "../inventory.php");
}

// If the product does not exist, insert it
$stmt = $db->prepare('INSERT INTO products (product_name, qty, price, created) VALUES (:product_name, :qty, :price, NOW())');

// Bind the values from the form
$stmt->bindParam(':product_name', $product_name);
$stmt->bindParam(':qty', $qty);
$stmt->bindParam(':price', $price);

// Execute the statement
$stmt->execute();

// Check if the statement was successful
if ($stmt->rowCount() > 0) {
    header('Location: ../inventory.php');
} else {
    displayErrorModal("An error occurred while adding the product.", "../inventory.php");
}
?>
