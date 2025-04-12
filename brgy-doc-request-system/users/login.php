<?php
session_start();
include_once '../includes/db_connect.php';

$error = "";

// Admin account setup (run once, then remove or comment this block)
$adminEmail = 'admin@example.com';
$adminPassword = 'admin123';
$checkAdmin = $conn->prepare("SELECT id FROM users WHERE email = ?");
$checkAdmin->bind_param("s", $adminEmail);
$checkAdmin->execute();
$checkAdmin->store_result();

if ($checkAdmin->num_rows === 0) {
    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
    $full_name = "Admin User";
    $role = "admin";

    $insertAdmin = $conn->prepare("INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES (NULL, ?, ?, ?, ?, current_timestamp())");
    $insertAdmin->bind_param("ssss", $full_name, $adminEmail, $hashedPassword, $role);
    $insertAdmin->execute();
    $insertAdmin->close();
}
$checkAdmin->close();

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $full_name, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role'] = $role;

            if ($role == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Barangay Buddy</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background: url('../assets/images/background.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 400px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 40px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        border-radius: 10px;
        text-align: center;
    }

    .container img.logo {
        width: 100px;
        height: 100px;
        margin-bottom: 10px;
        border-radius: 50%;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    input[type="email"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #1976d2;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #145ca3;
    }

    .toggle-password {
        cursor: pointer;
        font-size: 0.9em;
        color: #1976d2;
        margin-left: 5px;
        display: inline-block;
        margin-top: -10px;
    }

    p {
        margin-top: 15px;
    }

    a {
        color: #1976d2;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .error {
        color: red;
        margin-bottom: 15px;
    }
</style>
</head>
<body>
    <div class="container">
        <!-- LOGO -->
        <img src="../assets/images/logo.png" alt="Logo" class="logo">

        <h2>User/Admin Login</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form id="loginForm" method="POST">
            <input type="email" name="email" id="email" placeholder="Email address" required>
            
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" id="togglePassword">Show</span>

            <button type="submit">Login</button>
        </form>

    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Show' : 'Hide';
        });

        // Prevent double submission
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', function () {
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;
            button.textContent = "Logging in...";
        });
    </script>
</body>
</html>
