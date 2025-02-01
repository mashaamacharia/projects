<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_POST['action'] === 'reset') {
    $email = $_SESSION['user_email'];

    $query = "UPDATE candidates SET description = NULL, photo_path = NULL WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile reset successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reset profile.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}
?>