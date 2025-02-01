<?php
// Database connection details
$host = 'localhost';
$dbname = 'chuka';
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$position = $_GET['position'];
$faculty = $_GET['faculty']; // Assuming this is passed for faculty rep

// Adjust query based on the position (faculty rep needs additional filtering)
if ($position === 'faculty-rep') {
    $stmt = $pdo->prepare("SELECT id, name, photo_path FROM candidates WHERE position = ? AND faculty = ?");
    $stmt->execute([$position, $faculty]);
} else {
    $stmt = $pdo->prepare("SELECT id, name, photo_path FROM candidates WHERE position = ?");
    $stmt->execute([$position]);
}

$candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($candidates);
?>
