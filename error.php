<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <!-- Add your CSS stylesheets here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #ff5c5c;
            margin-bottom: 20px;
        }
        
        p {
            color: #333;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Error</h1>
        <p>An error occurred while processing your request:</p>
        <p><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : 'Unknown error'; ?></p>
        <p>Please try again later or contact support for assistance.</p>
    </div>
</body>
</html>

</head>
<body>
    <div class="container">
        <h1>Error</h1>
        <p>An error occurred while processing your request:</p>
        <p><?php echo isset($_SESSION['error']) ? $_SESSION['error'] : 'Unknown error'; ?></p>
        <p>Please try again later or contact support for assistance.</p>
    </div>
</body>
</html>
