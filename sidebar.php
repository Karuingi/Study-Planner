<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Progress Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #container {
            display: flex;
        }
        #studyProgressChart {
            flex: 1;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="content">
            <!-- Your existing content for the left side of the page goes here -->
            <h1>Welcome to the Study Progress Dashboard</h1>
            <!-- Add your other content here -->
        </div>
        <div id="studyProgressChartContainer">
            <canvas id="studyProgressChart" width="400" height="400"></canvas>
        </div>
    </div>

    <script src="chart_data.js"></script>
    <script src="chart_script.js"></script>
</body>
</html>
