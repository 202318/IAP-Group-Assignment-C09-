<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookstore Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        main {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            text-decoration: none;
            background: #007bff;
            color: white;
            border-radius: 8px;
            transition: 0.3s;
        }
        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>📚 Bookstore Management Dashboard</h1>
    </header>
    <main>
        <h2>Choose an option:</h2>
        <a href="register.php">➕ Register New User</a>
        <a href="verify_2fa.php">🔐 Verify 2FA</a>
        <a href="users.php">👥 View All Users</a>
        <a href="books.php">📖 View Books</a>
    </main>
</body>
</html>
