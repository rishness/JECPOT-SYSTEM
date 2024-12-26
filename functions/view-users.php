<?php
// Connect to the database
$db = new mysqli("localhost", "root", "", "db_hash");

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get all the rows from the `users` table
$sql = "SELECT * FROM users";
$result = $db->query($sql);

// Check if there are any rows in the result set
if ($result->num_rows > 0) {
    // Loop through the result set and print each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["created"] . "</td>";
        
        // Uniform size for all buttons
        echo "<td>
        <button class=\"btn btn-warning btn-sm btn-icon-split\" type=\"button\" style=\"margin: 2px;\" data-bs-target=\"#update\" data-bs-toggle=\"modal\" data-user-id=\"{$row['id']}\">
            <span class=\"text-white-50 icon\"><i class=\"fas fa-exclamation-triangle\"></i></span>
            <span class=\"text-white text\">Password</span>
        </button>
        
        </td>";

        echo "</tr>";
    }
} else {
    echo "No rows found";
}

// Close the database connection
$db->close();
?>
