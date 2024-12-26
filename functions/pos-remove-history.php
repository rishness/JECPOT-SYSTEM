<?php
session_start();

try {
    // Check if the required POST data is available
    if (!isset($_POST['history_id'], $_POST['product_id'], $_POST['product_qty'])) {
        throw new Exception('Missing required data.');
    }

    // Get the history ID, product ID, and quantity from the form
    $history_id = (int)$_POST['history_id'];
    $product_id = (int)$_POST['product_id'];
    $qty = (int)$_POST['product_qty'];

    if ($history_id <= 0 || $product_id <= 0 || $qty <= 0) {
        throw new Exception('Invalid input. All values must be positive integers.');
    }

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin a transaction for consistency
    $db->beginTransaction();

    // Delete the product from the history table
    $sql = "DELETE FROM history WHERE id = :history_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':history_id', $history_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception('Failed to delete the history record. Record may not exist.');
    }

    // Get the current quantity of the product from the products table
    $sql = "SELECT qty FROM products WHERE id = :product_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception('Product not found in the database.');
    }

    $row = $stmt->fetch();
    $current_qty = (int)$row['qty'];

    // Update the quantity of the product
    $new_qty = $current_qty + $qty;
    $sql = "UPDATE products SET qty = :new_qty WHERE id = :product_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':new_qty', $new_qty, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception('Failed to update the product quantity.');
    }

    // Commit the transaction
    $db->commit();

    // Redirect to the POS page
    header('Location: ../point-of-sale.php');
    exit;

} catch (Exception $e) {
    // Rollback the transaction in case of error
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }

    // Display the error message or redirect to an error page
    echo 'Error: ' . $e->getMessage();
}
?>
