<?php
session_start();
include_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT document_type, purpose, status, request_date FROM requests WHERE user_id = ? ORDER BY request_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Request Status</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Document Requests</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Document</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                        <td>
                            <?php
                            $statusColor = [
                                'Pending' => 'orange',
                                'Approved' => 'green',
                                'Declined' => 'red'
                            ];
                            echo "<span style='color: {$statusColor[$row['status']]}'>{$row['status']}</span>";
                            ?>
                        </td>
                        <td><?php echo date("M d, Y h:i A", strtotime($row['request_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No requests found.</p>
        <?php endif; ?>

        <p><a href="../users/dashboard.php">← Back to Dashboard</a></p>
    </div>
</body>
</html>
