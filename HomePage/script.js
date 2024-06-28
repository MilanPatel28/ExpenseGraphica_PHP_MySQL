// Create a new XMLHttpRequest object
var xhr = new XMLHttpRequest();

// Set up the request
xhr.open('GET', '../HomePage/fetchdataToHomepage.php', true);

// Set the callback function to handle the response
xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      console.log(xhr.responseText);
        // Check if the request was successful (status 200)
        if (xhr.status === 200) {
            // Parse the JSON response
            var data = JSON.parse(xhr.responseText);

            // Handle the data
            if (data.error) {
                // Handle unauthorized access or other errors
                console.error(data.error);
            } else {
                // Update total expenses in the div with class=total_exp
                document.querySelector('.total_exp').textContent = `Total Expenses = ${data.totalAllExpenses}₹`;

                // Update data for the chart
                var chartData = {
                    header: ["Month", "Total Expenses"],
                    rows: []
                };

                // Iterate over the total expenses of latest two months
                for (var month in data.totalLatestTwoMonths) {
                    chartData.rows.push([month, data.totalLatestTwoMonths[month]]);
                }

                // Create the chart
                var chart = anychart.column();
                chart.background().fill("transparent");
                chart.column().fill("#0066bb",0.8);
                chart.xAxis().labels().fontColor("black");
                chart.yAxis().labels().fontColor("black");
                chart.yAxis().labels().fontSize("18px");
                chart.yAxis().labels().fontSize("18px");
                chart.title().fontColor("black");
                chart.title().fontSize("18px");
                chart.title("Two Months Expenses");
                chart.labels(true);
                chart.labels().fontColor("black");
                chart.labels().fontSize("16px");
                // Add the data
                chart.data(chartData);


                // Draw the chart
                chart.container("breport_graph");
                chart.draw();

                var recentExpensesDiv = document.querySelector('.recent_exp');
                data.latestExpenses.forEach(expense => {
                    var expenseDiv = document.createElement('div');
                    expenseDiv.className = 'card';
                    expenseDiv.innerHTML = `
                        <p>${expense.date} &nbsp;&nbsp;&nbsp; ${expense.amount}₹</p>
                        <p>Category: ${expense.category}</p>
                        <p>Description: ${expense.description}</p>
                        <p>Mode of Payment: ${expense.mode_of_expense}</p>
                    `;
                    recentExpensesDiv.appendChild(expenseDiv);
                });
            }
        } else {
            // Handle other HTTP status codes
            console.error('Request failed with status:', xhr.status);
        }
    }
};

// Send the request
xhr.send();