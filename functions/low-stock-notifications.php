<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendLowStockNotification($db) {
    // Get all products with quantity less than or equal to 2
    $sql = "SELECT id, product_name, qty, last_email_sent FROM products WHERE qty <= 3";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $lowStockProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($lowStockProducts)) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'andayairishkate1@gmail.com'; // Your email address
            $mail->Password = 'proc wyfm xfsa eloe'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('andayairishkate1@gmail.com', 'JEC GENERAL MERCHANDISE');
            $mail->addAddress('andayairishkate1@gmail.com');

            // Email content
            $mail->isHTML(true); // Set to true to enable HTML formatting
            $mail->Subject = 'Low Stock Alert';

            // Email body with required styles
            $message = "
            <div style='font-size: 20px; font-weight: bold; color: black; margin-bottom: 15px;'>
                Hello Admin,
            </div>
            <div style='font-size: 18px; color: black; margin-bottom: 15px;'>
                The following products in your store are low in stock. Please update them for more earnings!
            </div>
            <div style='border-top: 2px solid black; margin-bottom: 10px;'></div>
            <div style='display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; margin-bottom: 5px;'>
                <div style='width: 65%; margin-left: 250px;'>Products</div>
                <div style='width: 65%; text-align: right; margin-right: 250px;'>Quantity</div>
            </div>
            <div style='border-bottom: 1px solid black; margin-bottom: 10px;'></div>
            ";

            // Loop through each product and add it to the message
            foreach ($lowStockProducts as $product) {
                $message .= "
                    <div style='display: flex; justify-content: space-between; font-size: 15px; color: gray;'>
                        <div style='width: 65%; margin-left: 250px;'>" . htmlspecialchars(mb_convert_case($product['product_name'], MB_CASE_TITLE, "UTF-8")) . "</div>
                        <div style='width: 65%; text-align: right; margin-right: 285px;'>" . htmlspecialchars($product['qty']) . "</div>
                    </div>
                ";
            }

            $mail->Body = $message;

            $productsToNotify = [];
            $currentDateTime = new DateTime();

            foreach ($lowStockProducts as $product) {
                $lastEmailSentDate = !empty($product['last_email_sent']) ? new DateTime($product['last_email_sent']) : null;
                $timeDifference = $lastEmailSentDate ? $lastEmailSentDate->diff($currentDateTime) : null;

                // Check if 24 hours have passed or if it's the first time an email is being sent
                if (!$lastEmailSentDate || ($timeDifference && ($timeDifference->h + ($timeDifference->d * 24)) >= 24)) {
                    $productsToNotify[] = $product;
                }
            }

            if (!empty($productsToNotify)) {
                // Send the email
                $mail->send();
                echo "<div style='font-size: 15px; font-weight: bold; color: red;'>LOW STOCK ALERT!</div>";

                // Update the `last_email_sent` timestamp for products notified
                foreach ($productsToNotify as $product) {
                    $updateSql = "UPDATE products SET last_email_sent = NOW() WHERE id = :id";
                    $updateStmt = $db->prepare($updateSql);
                    $updateStmt->execute([':id' => $product['id']]);
                }
            } else {
                echo "<p style='color: red;'>There are products with low stock. Please restock again!</p>";
            }
            } catch (Exception $e) {
                echo "<p style='color: red;'>Failed to send email. Error: {$mail->ErrorInfo}</p>";
            }
            } else {
                echo "No products are low in stock.";
            }
            
}
?>
