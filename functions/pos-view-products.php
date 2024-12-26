<?php
// Establish a database connection
try {
    $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Initialize the search term
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the SQL query to filter products
if (!empty($searchTerm)) {
    $sql = 'SELECT * FROM products WHERE product_name LIKE :searchTerm AND qty > 0 ORDER BY id ASC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
} else {
    $sql = 'SELECT * FROM products WHERE qty > 0 ORDER BY id ASC';
    $stmt = $db->prepare($sql);
}

$stmt->execute();
$products = $stmt->fetchAll();
?>

<!-- Search and Reset Functionality -->
<div class="mb-3 d-flex justify-content-between align-items-center">
    <form method="get" class="d-flex">
        <input 
            class="form-control me-2" 
            type="text" 
            name="search" 
            placeholder="Search Product Name" 
            value="<?php echo htmlspecialchars($searchTerm); ?>" 
            aria-label="Search for products"
        >
        <button class="btn btn-primary" type="submit" aria-label="Search">
            <i class="fas fa-search"></i> 
        </button>
    </form>
    <a href="point-of-sale.php" class="btn btn-secondary ms-2" aria-label="Reset Search">
        <i class="fas fa-sync-alt"></i>
    </a>
</div>



    <tbody>
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['qty']); ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td>
                        <button 
                            class="btn btn-info" 
                            type="button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#add-item" 
                            data-product-id="<?php echo htmlspecialchars($product['id']); ?>" 
                            aria-label="Add item to cart"
                        >
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">No products found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
