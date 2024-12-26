<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=db_hash', 'root', '');

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the user exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the password is correct
if ($user && password_verify($password, $user['password'])) {
    // Start the session and set session variables
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $user['id'];

    // Log the user sign-in action (without type and level)
    $stmt = $db->prepare('INSERT INTO user_logs (username, sign_in, created) VALUES (:username, NOW(), NOW())');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Redirect to the dashboard after successful login
    header('location: ../dashboard.php');
} else {
    // Redirect back to index.php with an error parameter
    header('location: ../index.php?error=invalid');
}
?>
