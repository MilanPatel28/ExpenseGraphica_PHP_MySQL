<?php
// Assuming you have already established a database connection.
require_once('../connection.php');

// Check if userId session variable is set
session_start();
if (!isset($_SESSION['userId'])) {
    // Handle unauthorized access or redirect to login page
    echo json_encode(array('error' => 'Unauthorized access'));
    exit;
}

$userId = $_SESSION['userId'];

// Fetch total expenses of all time
$query = "SELECT SUM(amount) AS total_amount FROM expenses WHERE user_id = $userId";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalAllExpenses = $row['total_amount'];

// Fetch the latest two distinct months from the expenses table
// $query = "SELECT DISTINCT month_year FROM (SELECT DATE_FORMAT(date, '%Y-%m') AS month_year FROM expenses WHERE user_id = $userId ORDER BY date DESC LIMIT 2) AS subquery";
$query = "SELECT DISTINCT month_year FROM (SELECT DATE_FORMAT(date, '%Y-%m') AS month_year FROM expenses WHERE user_id = 1 ORDER BY date DESC) AS subquery LIMIT 2";
$result = mysqli_query($conn, $query);
$months = array();
while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month_year'];
}

// Fetch total expenses for each of the latest two distinct months
$totalLatestTwoMonths = array();
foreach ($months as $month) {
    $query = "SELECT SUM(amount) AS total_amount FROM expenses WHERE user_id = $userId AND DATE_FORMAT(date, '%Y-%m') = '$month'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $totalLatestTwoMonths[$month] = $row['total_amount'];
}

// Fetch details of the two latest expenses
$query = "SELECT * FROM expenses WHERE user_id = $userId AND DATE_FORMAT(date, '%Y-%m') IN ('" . implode("','", $months) . "') ORDER BY date DESC LIMIT 2";
$result = mysqli_query($conn, $query);
$latestExpenses = array();
while ($row = mysqli_fetch_assoc($result)) {
    $latestExpenses[] = $row;
}

// Prepare data to be passed to JavaScript
$data = array(
    'totalLatestTwoMonths' => $totalLatestTwoMonths,
    'totalAllExpenses' => $totalAllExpenses,
    'latestExpenses' => $latestExpenses
);

// Convert data to JSON and echo it
echo json_encode($data);
?>
