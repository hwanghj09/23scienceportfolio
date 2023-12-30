<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbHost = 'svc.sel4.cloudtype.app:32632';
$dbUser = 'root';
$dbPassword = 'qwaszx77^^';
$dbName = 'nagwon';

// Create connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the announcement ID is provided
if (isset($_GET['id'])) {
    $announcementId = $_GET['id'];

    // Delete the announcement from the database
    $deleteSql = "DELETE FROM announcements WHERE id = $announcementId";

    if ($conn->query($deleteSql) === TRUE) {
        // Return success response
        echo json_encode(['status' => 'success']);
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    // Return error response if no ID is provided
    echo json_encode(['status' => 'error', 'message' => 'No announcement ID provided']);
}
?>
