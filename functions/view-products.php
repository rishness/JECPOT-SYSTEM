<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Check if the search term is set
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the query to filter results based on the search term and order by product ID
if (!empty($searchTerm)) {
    $sql = 'SELECT * FROM products WHERE product_name LIKE :searchTerm ORDER BY id ASC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
} else {
    $sql = 'SELECT * FROM products ORDER BY id ASC';  // Sorting by product ID in ascending order
    $stmt = $db->prepare($sql);
}

$stmt->execute();
$results = $stmt->fetchAll();

// Include the low stock notification function and trigger it
include_once 'functions/low-stock-notifications.php';
sendLowStockNotification($db);

// Display results
foreach ($results as $row) {
?>
    <tr>
        <td>&nbsp;<?php echo $row['id']; ?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['qty']; ?></td>
        <td><?php echo number_format($row['price'], 2); ?></td>
        <td><?php echo $row['created']; ?></td>
        <td>
            <button class="btn btn-success btn-icon-split" type="button" style="margin: 2px;"
                data-bs-target="#update-product" data-bs-toggle="modal" data-product-id="<?php echo $row['id']; ?>">
                <span class="text-white-50 icon"><i class="fas fa-check"></i></span>
                <span class="text-white text">Update</span>
            </button>
            <button class="btn btn-danger btn-icon-split" type="button" style="margin: 2px;"
                data-bs-target="#confirmation" data-bs-toggle="modal" data-product-id="<?php echo $row['id']; ?>">
                <span class="text-white-50 icon"><i class="fas fa-trash"></i></span>
                <span class="text-white text">Remove</span>
            </button>
        </td>
    </tr>
<?php
}
?>
