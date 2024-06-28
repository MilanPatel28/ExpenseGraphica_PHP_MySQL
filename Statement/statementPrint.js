// // script.js
// document.addEventListener('DOMContentLoaded', function () {
//     // Make an AJAX request to fetch_expenses.php
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '../Statement/fetchExpenses.php', true);
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState == 4 && xhr.status == 200) {
//             console.log(xhr.responseText);
//             // Parse the JSON response from the PHP file
//             var expenses = JSON.parse(xhr.responseText);

//             // Get the expenses-card element
//             var expensesCard = document.getElementById('expenses-card');

//             if (expenses.length > 0) {
//                 // Loop through the expenses and create cards for each expense
//                 expenses.forEach(function (expense, index) {
//                     // Convert the date string to a Date object
//                     var expenseDate = new Date(expense.date);
//                     // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
//                     var dayOfWeek = expenseDate.getDay();
//                     // Array of day names
//                     var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

//                     var cardDiv = document.createElement('div');
//                     cardDiv.className = 'card';
//                     cardDiv.innerHTML = `
//                         <p>${daysOfWeek[dayOfWeek]}, &nbsp; ${expense.date}</p>
//                         <p>Amount: ${expense.amount}/-</p>
//                         <p>Category: ${expense.category}</p>
//                         <p>Description: ${expense.description}</p>
//                         <p>Mode of Payment: ${expense.mode_of_expense}</p>
//                     `;
//                     expensesCard.appendChild(cardDiv);
//                 });

//                 // Update the Total Expenses card
//                 var totalExpensesCard = document.getElementById('heading-card');
//                 var totalAmount = expenses.reduce(function (total, expense) {
//                     return total + parseFloat(expense.amount);
//                 }, 0);
//                 totalExpensesCard.textContent = 'Total Expenses : ' + totalAmount + ' Rs';
//             } else {
//                 // If no expenses are found, display a message
//                 expensesCard.textContent = 'No expenses found for this user.';
//             }
//         }
//     };
//     xhr.send();
// });

// Function to format dates as DD-MM-YYYY
function formatDate(dateString) {
    var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(dateString).toLocaleDateString('en-GB');
}

document.addEventListener('DOMContentLoaded', function () {
    // Make an AJAX request to fetch_expenses.php
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../Statement/fetchExpenses.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Parse the JSON response from the PHP file
            var expenses = JSON.parse(xhr.responseText);

            // Sort expenses array by dates in ascending order
            expenses.sort(function (a, b) {
                // Convert date strings to Date objects for comparison
                var dateA = new Date(a.date);
                var dateB = new Date(b.date);
                return dateA - dateB;
            });

            // Get the expenses-card element
            var expensesCard = document.getElementById('expenses-card');

            if (expenses.length > 0) {
                // Loop through the sorted expenses and create cards for each expense
                expenses.forEach(function (expense, index) {
                    // Convert the date string to formatted DD-MM-YYYY
                    var formattedDate = formatDate(expense.date);
                    // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                    var dayOfWeek = new Date(expense.date).getDay();
                    // Array of day names
                    var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                    var cardDiv = document.createElement('div');
                    cardDiv.className = 'card';
                    cardDiv.innerHTML = `
                        <p>${daysOfWeek[dayOfWeek]} &nbsp; ${formattedDate}</p>
                        <p>Amount: ${expense.amount}/-</p>
                        <p>Category: ${expense.category}</p>
                        <p>Description: ${expense.description}</p>
                        <p>Mode of Payment: ${expense.mode_of_expense}</p>
                    `;
                    expensesCard.appendChild(cardDiv);
                });

                // Update the Total Expenses card
                var totalExpensesCard = document.getElementById('heading-card');
                var totalAmount = expenses.reduce(function (total, expense) {
                    return total + parseFloat(expense.amount);
                }, 0);
                totalExpensesCard.textContent = 'Total Expenses : ' + totalAmount + ' Rs';
            } else {
                // If no expenses are found, display a message
                expensesCard.textContent = 'No expenses found for this user.';
            }
        }
    };
    xhr.send();
});
