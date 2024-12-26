<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Initialize the query for filtering by transaction date
$sql = 'SELECT * FROM transaction WHERE 1';

// Check if a transaction date is provided
if (isset($_GET['transaction_date']) && !empty($_GET['transaction_date'])) {
    $transaction_date = $_GET['transaction_date'];
    $sql .= ' AND DATE(created) = :transaction_date'; // Filter based on the exact date
}

// Prepare and execute the SQL statement
$stmt = $db->prepare($sql);

// Bind the transaction date parameter if provided
if (isset($transaction_date)) {
    $stmt->bindParam(':transaction_date', $transaction_date);
}

$stmt->execute();
$results = $stmt->fetchAll();

// Loop through the results and add them to the table
foreach ($results as $row) {
?>
    <tr>      
    <td><?php echo number_format($row['sales'], 2); ?></td>
    <td><?php echo number_format($row['discounted_sales'] - $row['sales'], 2); ?></td>
    <td><?php echo number_format($row['amount'], 2); ?></td>
    <td><?php echo number_format($row['discounted_sales'], 2); ?></td>

        <td><?php echo $row['created']; ?></td>
    </tr>
<?php

}
function get_username($user_id){
    $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        ?>
        <td><?php echo $row['username']; ?></td>
        <?php
    }

}


?>

