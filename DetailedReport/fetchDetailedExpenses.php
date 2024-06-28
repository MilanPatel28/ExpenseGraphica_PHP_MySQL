<?php
// Assuming you have established a database connection
require_once '../connection.php';
session_start();

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    // Task 1: Calculate total expenses and average daily expense
    $sqlTotalExpenses = "SELECT SUM(amount) AS totalExpenses, COUNT(*) AS totalCount FROM expenses WHERE user_id = $userId";
    $resultTotalExpenses = mysqli_query($conn, $sqlTotalExpenses);
    $rowTotalExpenses = mysqli_fetch_assoc($resultTotalExpenses);
    $totalExpenses = $rowTotalExpenses['totalExpenses'];
    $totalCount = $rowTotalExpenses['totalCount'];

    $averageDailyExpense = ($totalCount > 0) ? round($totalExpenses / $totalCount, 2) : 0;

    // Task 2: Calculate category-wise expenses (count and total amount)
    $sqlCategoryExpenses = "SELECT category, COUNT(*) AS numExpenses, SUM(amount) AS categoryTotal FROM expenses WHERE user_id = $userId GROUP BY category";
    $resultCategoryExpenses = mysqli_query($conn, $sqlCategoryExpenses);
    $categoryData = array();
    while ($rowCategoryExpenses = mysqli_fetch_assoc($resultCategoryExpenses)) {
        $categoryData[$rowCategoryExpenses['category']] = array(
            "count" => $rowCategoryExpenses['numExpenses'],
            "totalAmount" => $rowCategoryExpenses['categoryTotal']
        );
    }

    // Task 3: Calculate month-wise expenses for the current year
    $currentYear = date("Y");
    $sqlMonthExpenses = "SELECT MONTH(date) AS month, SUM(amount) AS monthTotal FROM expenses WHERE user_id = $userId AND YEAR(date) = $currentYear GROUP BY MONTH(date)";
    $resultMonthExpenses = mysqli_query($conn, $sqlMonthExpenses);
    $monthData = array_fill(1, 12, 0); // Initialize month-wise data array with zeros
    while ($rowMonthExpenses = mysqli_fetch_assoc($resultMonthExpenses)) {
        $monthData[$rowMonthExpenses['month']] = $rowMonthExpenses['monthTotal'];
    }

    // Prepare data for JSON encoding
    $data = array(
        "totalExpenses" => $totalExpenses,
        "averageDailyExpense" => $averageDailyExpense,
        "categoryData" => $categoryData,
        "monthData" => $monthData
    );

    // Encode data to JSON and send it to the JavaScript code
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // Handle the case when the session variable userId is not set
    echo json_encode(array("error" => "Session variable userId not set."));
}
?>
