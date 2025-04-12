<?php
session_start();
include_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../users/login.php");
    exit();
}

$sql = "SELECT requests.id, users.full_name, document_type, purpose, status, request_date
        FROM requests
        JOIN users ON requests.user_id = users.id
        ORDER BY request_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Manage Requests</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f3f3f3; }
        .btn {
            padding: 5px 10px;
            margin: 0 2px;
            text-decoration: none;
            border-radius: 4px;
        }
        .approve { background-color: green; color: white; }
        .decline { background-color: red; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?> (<a href="../logout.php">Logout</a>)</p>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>User</th>
                    <th>Document</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Requested On</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo date("M d, Y h:i A", strtotime($row['request_date'])); ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a class="btn approve" href="manage_requests.php?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
                                <a class="btn decline" href="manage_requests.php?action=decline&id=<?php echo $row['id']; ?>">Decline</a>
                            <?php else: ?>
                                <em>No actions</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a class="btn approve" href="#" data-id="<?php echo $row['id']; ?>">Approve</a>
                                 <a class="btn decline" href="#" data-id="<?php echo $row['id']; ?>">Decline</a>
                            <?php else: ?>
                            <em>No actions</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No requests found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
require('fpdf/fpdf.php'); // Include the FPDF library

// Fetch request details from the database
include_once '../includes/db_connect.php';
$request_id = $_GET['id']; // Assume ID is passed
$sql = "SELECT document_type, purpose, request_date FROM requests WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $request_id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();

// Generate PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'Barangay Document Request', 0, 1, 'C');
$pdf->Ln(10);

// Add request details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 10, "Document Type: " . $request['document_type'], 0, 1);
$pdf->Cell(100, 10, "Purpose: " . $request['purpose'], 0, 1);
$pdf->Cell(100, 10, "Requested On: " . date('M d, Y h:i A', strtotime($request['request_date'])), 0, 1);

// Output the PDF
$pdf->Output('D', 'request_' . $request_id . '.pdf');
?>
<script src="../assets/js/admin-dashboard.js"></script>
