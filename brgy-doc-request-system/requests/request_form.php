<?php
session_start();
include_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $doc_type = $_POST['document_type'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("INSERT INTO requests (user_id, document_type, purpose) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $doc_type, $purpose);

    if ($stmt->execute()) {
        $success = "Request submitted successfully!";
    } else {
        $error = "Failed to submit request.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Request a Barangay Document</h2>

        <?php if ($success): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Document Type:</label><br>
            <select name="document_type" required>
                <option value="Barangay Clearance">Barangay Clearance</option>
                <option value="Certificate of Indigency">Certificate of Indigency</option>
                <option value="Certificate of Residency">Certificate of Residency</option>
            </select><br><br>

            <label>Purpose:</label><br>
            <textarea name="purpose" rows="4" required></textarea><br><br>

            <button type="submit">Submit Request</button>
        </form>

        <p><a href="../users/dashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
<script src="../assets/js/form-validation.js"></script>

</html>
