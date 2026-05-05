<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background: #0056b3;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
        nav {
            margin-top: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        nav a:hover {
            background: #004494;
        }
        main {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>

    <header>
        <h2>MVC Product Management</h2>
        <nav>
            <a href="/products">View All Products</a>
            <a href="/products/create">Add New Product</a>
        </nav>
    </header>

    <main>
        <!-- 
          This is the core magic of the layout file. 
          The Base Controller assigns the path of your specific view (like index.php or create.php) 
          to the $content variable, and then injects it right here! 
        -->
        <?php 
        /** @var string $content */
        require $content; 
    ?>
    </main>

</body>
</html>