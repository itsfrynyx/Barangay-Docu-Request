<?php
include_once '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../users/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT full_name, document_type, purpose, status, DATE_FORMAT(request_date, '%M %d, %Y %h:%i %p') as request_date 
        FROM requests
        JOIN users ON requests.user_id = users.id
        WHERE user_id = ?
        ORDER BY request_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode($requests);
?>
<script src="../assets/js/request-status.js"></script>
