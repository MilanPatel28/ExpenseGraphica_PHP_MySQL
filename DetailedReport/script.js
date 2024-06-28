anychart.onDocumentReady(function () {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../DetailedReport/fetchDetailedExpenses.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            // Task 1: Update total expenses and average daily expense
            document.getElementById('c2').textContent = 'Average Daily Expense = Total Expense / No of days = ' + data.averageDailyExpense + '₹';

            // Task 2: Update category-wise expenses for the pie chart
            var categoryData = [];
            for (var category in data.categoryData) {
                categoryData.push({ x: category, value: data.categoryData[category].count });
            }
            var pieChart = anychart.pie();
            pieChart.title('Category wise expenses');
            pieChart.data(categoryData);
            configurePieChart(pieChart);
            pieChart.container('container1');
            pieChart.draw();

            // Task 3: Update month-wise expenses for the area chart
            var monthData = [];
            var monthName = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
            let i=0;
            for (var month in data.monthData) {
                monthData.push({ x: monthName[i], value: data.monthData[month] });
                i++;
            }
            var areaChart = anychart.area();
            areaChart.title('Month wise expenses');
            areaChart.data(monthData);
            congifureAreaChart(areaChart);
            areaChart.container('container2');
            areaChart.draw();
        }
    };
    xhr.send();

    function configurePieChart(chart) {
        chart.background().fill("transparent");
        chart.legend().fontColor("black");
        chart.legend().fontSize("22px");
        chart.title().fontColor("black");
        chart.title().fontSize("22px");
        chart.legend().position("bottom");
    }

    function congifureAreaChart(chart) {
        chart.background().fill("transparent");
        chart.legend().fontColor("black");
        chart.legend().fontSize("22px");
        chart.title().fontColor("black");
        chart.title().fontSize("22px");
        chart.legend().position("bottom");
        chart.labels().fontColor("black")
        chart.labels().fontSize("15px");
        chart.xAxis().labels().fontColor("black");
        chart.xAxis().labels().fontSize("15px");
        chart.yAxis().labels().fontColor("black");
        chart.yAxis().labels().fontSize("15px");
        chart.labels(true);
    }
});