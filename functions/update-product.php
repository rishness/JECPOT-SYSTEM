        <?php
        // Get the product ID from the POST request
        $product_id = $_POST['product_id'];

        // Get the product name, quantity, and price from the POST request
        // $product_name = $_POST['product_name'];
        $qty = $_POST['qty'];
        $price = $_POST['price'];

        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

        // Check if the product already exists in the database
        $sql = "SELECT * FROM products WHERE product_name = :product_name AND id != :product_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $results = $stmt->fetchAll();

        // If the product already exists in the database, do nothing
        if (count($results) > 0) {
            header('Location: ../404.php?message=Product already exists in the database.&error=Product Name Already Exists');
            exit;
        }

        // Update the product in the database
        $sql = "UPDATE products SET  qty = :qty, price = :price WHERE id = :product_id";
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':qty', $qty);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            // The update was successful, redirect the user to the product list page
            header('Location: ../inventory.php');
        } else {
            // The update was not successful, show an error message
            echo 'Error updating product.';
        }
        ?>


