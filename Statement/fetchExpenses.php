<?php
// fetch_expenses.php
require_once('../connection.php');
session_start();

// $servername = "your_server_name";
// $username = "your_username";
// $password = "your_password";
// $database = "your_database_name";

// // Create a connection
// $conn = new mysqli($servername, $username, $password, $database);

// // Check the connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Get user_id from the session variable
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    // Fetch expenses data for the specific user_id
    $sql = "SELECT * FROM expenses WHERE user_id = $userId";
    $result = $conn->query($sql);

    $expenses = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }
    }

    // Close the connection
    $conn->close();

    // Return expenses data as JSON
    header('Content-Type: application/json');
    echo json_encode($expenses);
} else {
    // If user_id is not set in the session, return an empty array
    echo json_encode([]);
}
?>
