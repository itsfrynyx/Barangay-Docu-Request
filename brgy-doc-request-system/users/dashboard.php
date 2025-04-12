<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Barangay Document System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            color: #1976d2;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: #444;
            font-size: 16px;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 15px 0;
        }

        ul li a {
            text-decoration: none;
            color: #fff;
            background-color: #1976d2;
            padding: 12px 25px;
            border-radius: 8px;
            display: inline-block;
            width: 80%;
            max-width: 300px;
            transition: background-color 0.3s, transform 0.2s;
            font-size: 16px;
        }

        ul li a:hover {
            background-color: #145ca3;
            transform: scale(1.05);
        }

        @media (max-width: 600px) {
            .container {
                margin: 40px 20px;
                padding: 30px 20px;
            }

            ul li a {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>

        <p>Hi there, kaBarangay! Need help with document requests? We're ready to assist you. 🤝</p>

        <ul>
            <li><a href="../requests/request_form.php">📄 Request a Document</a></li>
            <li><a href="../requests/status.php">📊 Track My Requests</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>
</body>
</html>
