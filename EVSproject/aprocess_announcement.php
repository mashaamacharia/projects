<?php
header('Content-Type: application/json');

include 'connection.php';

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]));
}

$announcement = $_POST['announcement'];

$stmt = $conn->prepare("INSERT INTO announcements (announcement) VALUES (?)");
$stmt->bind_param("s", $announcement);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => "Announcement posted successfully"]);
} else {
    echo json_encode(['success' => false, 'message' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>