<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Document Request System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: url('assets/images/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        header {
            background-color: rgba(0, 123, 255, 0.85);
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
            border-radius: 50%;
            
        }

        main {
            background-color: rgba(255, 255, 255, 0.95);
            margin: 40px auto;
            padding: 40px 20px;
            text-align: center;
            width: 80%;
            max-width: 800px;
            border-radius: 12px;
        }
        .cta-buttons {
            margin-top: 30px;
        }

        .cta-buttons a {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 12px 24px;
            margin: 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .cta-buttons a:hover {
            background-color: #0056b3;
        }

        .contact-info {
            margin-top: 50px;
            text-align: left;
        }

        .contact-info h3 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        .contact-info p {
            margin: 5px 0;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <header>
        <img src="assets/images/logo.png" alt="Barangay Logo">
        <h1>Barangay Document Request System</h1>
        <p>Request your barangay documents online easily and quickly!</p>
    </header>

    <main>
        <h2>What do you want to do?</h2>
        <div class="cta-buttons">
            <a href="users/login.php">Login</a>
            <a href="users/signup.php">Sign Up</a>
        </div>

        <p style="margin-top:40px;">Need a Barangay Clearance, Certificate of Residency, or Indigency? You're in the right place!</p>

        <div class="contact-info">
            <h3>Contact Us</h3>
            <p><strong>Barangay:</strong> Barangay Buddy</p>
            <p><strong>Email:</strong> brgy.buddy@example.com</p>
            <p><strong>Phone:</strong> (093) 123-4567</p>
            <p><strong>Office Hours:</strong> Mon - Fri, 8:00 AM to 5:00 PM</p>
        </div>
    </main>

    <footer>
        &copy; <?php echo date("Y"); ?> Barangay Buddy
    </footer>
</body>
</html>
