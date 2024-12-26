<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Initialize the query for filtering by transaction date and product name
$sql = 'SELECT * FROM history WHERE 1';

// Check if a transaction date is provided
if (isset($_GET['transaction_date']) && !empty($_GET['transaction_date'])) {
    $transaction_date = $_GET['transaction_date'];
    $sql .= ' AND DATE(created) = :transaction_date'; // Filter based on the exact date
}

// Check if a product name is provided
if (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
    $product_name = $_GET['product_name'];
    $sql .= ' AND product_name LIKE :product_name'; // Filter based on the product name
}

// Prepare and execute the SQL statement
$stmt = $db->prepare($sql);

// Bind the parameters if provided
if (isset($transaction_date)) {
    $stmt->bindParam(':transaction_date', $transaction_date);
}

if (isset($product_name)) {
    $searchTerm = "%" . $product_name . "%"; // Use wildcards for partial matching
    $stmt->bindParam(':product_name', $searchTerm);
}

$stmt->execute();
$results = $stmt->fetchAll();

// Loop through the results and add them to the table
foreach ($results as $row) {
?>
    <tr>
        <td>&nbsp;<?php echo htmlspecialchars($row['product_name']); ?></td>
        <td><?php echo htmlspecialchars($row['qty']); ?></td>
        <td><?php echo '' . number_format($row['price'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['created']); ?></td>
    </tr>
<?php
}
?>
