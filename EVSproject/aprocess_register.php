<?php
header('Content-Type: application/json');

include 'connection.php';

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

$name = $_POST['name'] ?? '';
$position = $_POST['position'] ?? '';
$faculty = $_POST['faculty'] ?? null;
$email = $_POST['email'] ?? '';

// Validate required fields
if (empty($name) || empty($position) || empty($email)) {
    echo json_encode(['success' => false, 'message' => "Name, position, and email are required"]);
    exit();
}

// Validate email exists in details table
$stmt = $conn->prepare("SELECT email FROM details WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => "Email not found"]);
    exit();
}
$stmt = $conn->prepare("SELECT email FROM candidates WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => "This email is already registered"]);
    exit();
}

// Prepare the SQL statement
if ($position === 'faculty-rep' && $faculty !== null) {
    $stmt = $conn->prepare("INSERT INTO candidates (name, position, faculty, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $position, $faculty, $email);
} else {
    $stmt = $conn->prepare("INSERT INTO candidates (name, position, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $position, $email);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => "Candidate registered successfully"]);
} else {
    echo json_encode(['success' => false, 'message' => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>