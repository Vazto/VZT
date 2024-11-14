<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Layout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f0ee;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            gap: 20px;
        }

        .sidebar {
            background: white;
            width: 250px;
            height: fit-content;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .main-content {
            background: white;
            flex-grow: 1;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Contenido del sidebar -->
    </div>
    <div class="main-content">
        <!-- Contenido principal -->
    </div>
</body>
</html>