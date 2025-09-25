<!-- resources/views/errors/503.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Unavailable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            background-color: #ffffff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .error-container h3 {
            font-size: 3em;
            color: #f56c6c;
            margin-bottom: 20px;
        }

        .error-container p {
            font-size: 1.2em;
            color: #888;
        }

        .error-container a {
            font-size: 1em;
            color: #007bff;
            text-decoration: none;
        }

        .error-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="error-container">
    <h3>503 - Service Unavailable</h3>
    <p>Sorry, we are currently undergoing maintenance. Please try again later.</p>
</div>

</body>
</html>
