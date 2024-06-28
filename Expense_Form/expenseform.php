<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../Navbar/style.css">
    </link>
    <style>
        :root {
            font-size: 20px;
            box-sizing: inherit;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        p {
            margin: 0;
        }

        p:not(:last-child) {
            margin-bottom: 1.5em;
        }

        body {
            font: 1em/1.618 Inter, sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            min-height: 100vh;
            padding: 30px;

            color: #224;
            background: url(https://source.unsplash.com/E8Ufcyxz514/2400x1823) center / cover no-repeat fixed;
        }

        .card {
            min-width: 40vw;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

            max-width: 700px;
            height: fit-content;
            padding: 35px;

            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.45);
            box-shadow: 0 0 10px 1px rgba(0, 0, 0, 0.25);

            backdrop-filter: blur(15px);
        }

        .card-footer {
            font-size: 0.65em;
            color: #446;
        }

        li {
            min-width: 20vw;
        }
        a {
            max-width:18vw;
        }

        .submitbtn {
            width: 10vw;
            margin-left:35%;
        }

        label {
            font-size:1.2rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        input {
            border-radius:8px;
            padding: 7px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    require_once('../connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["userId"])) {
        $user_id = $_SESSION["userId"];
        $amount = $_POST["amount"];
        $category = $_POST["category"];
        $mode_of_expense = $_POST["mode_of_expense"];
        $date = $_POST["date"];
        $description = $_POST["description"];

        // Prepare the SQL query to insert data into expenses table
        $sql = "INSERT INTO expenses (user_id, amount, category, mode_of_expense, date, description) 
            VALUES ('$user_id', '$amount', '$category', '$mode_of_expense', '$date', '$description')";

        // Execute the query

        if ($conn->query($sql) === TRUE) {
            echo "<script>
            window.onload = function() {
                var expenseDiv = document.getElementById('expense-alert');
                expenseDiv.innerHTML = '<div class=\"alert alert-success\" role=\"alert\">Expense Added Successfully</div>';
            };
            setTimeout(function() {
                var expenseAlertDiv = document.getElementById('expense-alert');
                if (expenseAlertDiv) {
                    expenseAlertDiv.innerHTML = ''; // Remove the content inside the div
                }
            }, 2000); // 2000 milliseconds = 2 seconds
          </script>";

        } else {
            // Error occurred, display the error message
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>

    <!-- Navbar -->
    <div id="nav-bar">
        <input id="nav-toggle" type="checkbox" checked />
        <div id="nav-header"><a id="nav-title" href="../HomePage/index.html" target="_blank">ExpenseGraphica</a>
            <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
            <hr />
        </div>
        <div id="nav-content">
            <a href="../Expense_Form/expenseform.php">
                <div class="nav-button"><i class="bi bi-plus-square"></i><span>Add Expense</span></div>
            </a>
            <a href=""></a>
            <a href="../Statement/statementPage.html">
                <div class="nav-button"><i class="bi bi-cash"></i><span>Statement</span></div>
            </a>
            <a href="../DetailedReport/index.html">
                <div class="nav-button"><i class="bi bi-bar-chart-line-fill"></i><span>Detailed Report</span></div>
            </a>
            <a href="../logout.php">
                <div class="nav-button"><i class="bi bi-box-arrow-left"></i><span>Log Out</span></div>
            </a>
        </div>
    </div>
    <!-- Navbar -->

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="card">
            <div id="expense-alert"></div>
            <label>Amount: </label>
            <input type="text" name="amount" required>
            <br>

            <label>Category: </label>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="categoryDropdown">
                    Select Category
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" onclick="setCategory('Food')">Food</a></li>
                    <li><a class="dropdown-item" onclick="setCategory('Bills')">Bills</a></li>
                    <li><a class="dropdown-item" onclick="setCategory('Health')">Health</a></li>
                    <li><a class="dropdown-item" onclick="setCategory('Transportation')">Transportation</a></li>
                    <li><a class="dropdown-item" onclick="setCategory('Shopping')">Shopping</a></li>
                    <li><a class="dropdown-item" onclick="setCategory('Entertainment')">Entertainment</a></li>
                </ul>
            </div>
            <input type="hidden" id="selectedCategory" name="category" required>
            <br>

            <label>Mode of expense: </label>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline1" name="mode_of_expense" class="custom-control-input" value="Online" required>
                <label class="custom-control-label" for="customRadioInline1">Online</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline2" name="mode_of_expense" class="custom-control-input" value="Offline" required>
                <label class="custom-control-label" for="customRadioInline2">Cash</label>
            </div>
            <br>

            <label>Date: </label>
            <input type="date" name="date" required>
            <br>

            <label>Description: </label>
            <input type="text" name="description" required>
            <br>

            <button type="submit" class="btn btn-success submitbtn">Add expense</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function setCategory(category) {
            document.getElementById('selectedCategory').value = category;
            document.getElementById('categoryDropdown').innerText = category;
        }
    </script>

</body>
</html>