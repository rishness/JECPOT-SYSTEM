<?php

// Get the product ID from the form
$product_id = $_POST['product_id'];

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Begin a transaction to ensure atomicity
$db->beginTransaction();

try {
    // Delete related records in the history table
    $sql = 'DELETE FROM history WHERE product_id = :product_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    // Now delete the product
    $sql = 'DELETE FROM products WHERE id = :product_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();

    // Commit the transaction
    $db->commit();

    // Redirect to the inventory page
    header('Location: ../inventory.php');
} catch (Exception $e) {
    // If an error occurs, rollback the transaction
    $db->rollBack();
    echo 'Error: ' . $e->getMessage();
}

?>
