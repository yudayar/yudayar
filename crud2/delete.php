<?php
// Include database connection file
include_once("config.php");

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    // Get the user id from the URL
    $id = $_GET['id'];

    // Perform the delete operation
    $result = mysqli_query($mysqli, "DELETE FROM users WHERE id=$id");

    // After deletion, redirect back to index.php
    if ($result) {
        header("Location: index.php");
        exit(); // Ensure the script stops after the redirect
    } else {
        echo "Error deleting record: " . mysqli_error($mysqli);
    }
} else {
    // If 'id' is not set, redirect back to index.php
    header("Location: index.php");
    exit();
}
?>
