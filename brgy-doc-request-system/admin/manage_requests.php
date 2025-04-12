<?php
session_start();
include_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../users/login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = intval($_GET['id']);

    if ($action == 'approve') {
        $status = 'Approved';
    } elseif ($action == 'decline') {
        $status = 'Declined';
    } else {
        header("Location: dashboard.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
