<?php
session_start();

try {
    // Check if product ID and quantity are provided
    if (!isset($_POST['product_id'], $_POST['item_qty'])) {
        throw new Exception('Product ID or quantity not provided.');
    }

    // Get the product ID and quantity from the POST request
    $product_id = (int)$_POST['product_id'];
    $qty = (int)$_POST['item_qty'];

    if ($qty <= 0) {
        throw new Exception('Invalid quantity. Must be greater than zero.');
    }

    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['id'])) {
        throw new Exception('User not logged in.');
    }
    $user_id = $_SESSION['id'];

    // Get the product information from the database
    $sql = "SELECT product_name, price, qty FROM products WHERE id = :product_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception('Product not found.');
    }

    $row = $stmt->fetch();
    $product_name = $row['product_name'];
    $price = $row['price'];
    $current_qty = $row['qty'];

    // Check if the quantity is available
    if ($current_qty < $qty) {
        throw new Exception('Insufficient stock available.');
    }

    // Check if the product already exists in the history table
    $sql = "SELECT * FROM history WHERE user_id = :user_id AND product_id = :product_id AND status = ''";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Begin a transaction for consistency
    $db->beginTransaction();

    if (count($results) == 0) {
        // Update product stock
        $new_qty = $current_qty - $qty;
        $sql = "UPDATE products SET qty = :new_qty WHERE id = :product_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':new_qty', $new_qty, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Insert into history table
        $sql = "INSERT INTO history (user_id, product_id, product_name, qty, price, created) 
                VALUES (:user_id, :product_id, :product_name, :qty, :price, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        // Update quantity in history
        $sql = "UPDATE history SET qty = qty + :qty WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update product stock
        $new_qty = $current_qty - $qty;
        $sql = "UPDATE products SET qty = :new_qty WHERE id = :product_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':new_qty', $new_qty, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Commit the transaction
    $db->commit();

    // Redirect to the POS page
    header('Location: ../point-of-sale.php');
    exit;

} catch (Exception $e) {
    // Rollback transaction in case of error
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }

    // Display error message or redirect to an error page
    echo 'Error: ' . $e->getMessage();
}
?>
