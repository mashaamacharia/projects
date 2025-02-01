<?php
// Database connection
require 'connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch candidates grouped by position and faculty
$sql = "SELECT * FROM candidates ORDER BY 
    CASE 
        WHEN position = 'president' THEN 1
        WHEN position = 'deputy' THEN 2
        WHEN position = 'faculty-rep' THEN 3
        ELSE 4
    END, 
    faculty, 
    id";

$result = $conn->query($sql);

$candidates = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $candidates[$row['position']][] = $row;
    }
}

$conn->close();

// Function to check if image file exists
function imageExists($path) {
    return file_exists($path) && is_file($path);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contestants Page</title>
    <link rel="stylesheet" href="contestants.css">
</head>
<body>
     <header>
        <img src="Images/chukalogo.jpeg" alt="chuka university Icon" class="icon"> <br>
    </header>
    <div class="overlay"></div>
    <br>
    <h1>Chuka University Contestants</h1> 
    <div class="container">
        <?php foreach ($candidates as $position => $positionCandidates): ?>
            <h2><?= ucfirst($position) ?></h2>
            <div class="candidates-row">
                <?php foreach ($positionCandidates as $candidate): ?>
                    <div class="candidate-card">
                        <?php if (imageExists($candidate['photo_path'])): ?>
                            <img src="<?= $candidate['photo_path'] ?>" alt="" class="candidate-image">
                        <?php else: ?>
                            <div class="placeholder-image"></div>
                        <?php endif; ?>
                        <div class="candidate-info">
                            <h3><?= $candidate['name'] ?></h3>
                            <p><?= $candidate['faculty'] ?></p>
                            <button class="details-btn" onclick="toggleDetails(this)">Details</button>
                            <div class="candidate-description" style="display: none;">
                                <?= $candidate['description'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="contestants.js"></script>
</body>
</html>
