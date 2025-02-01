<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['errorMsg'] = "You must be logged in to submit data.";
        header("Location: candidateloginpage.php");
        exit();
    }

    // Sanitize and validate the input
    $email = $_SESSION['user_email'];
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $photo = $_FILES['photo'];

    if (!$description || !$photo) {
        $_SESSION['errorMsg'] = "All fields are required.";
        header("Location: candidatehomepage.php");
        exit();
    }

    // Validate image upload
    $targetDir = "uploads/";
    $imageFileType = strtolower(pathinfo($photo["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . uniqid() . '.' . $imageFileType; // Generate unique filename

    // Check if file is an actual image
    $check = getimagesize($photo["tmp_name"]);
    if ($check === false) {
        $_SESSION['errorMsg'] = "File is not an image.";
        header("Location: candidatehomepage.php");
        exit();
    }

    // Check file size (e.g., 2MB maximum)
    if ($photo["size"] > 2000000) {
        $_SESSION['errorMsg'] = "Sorry, your file is too large.";
        header("Location: candidatehomepage.php");
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION['errorMsg'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        header("Location: candidatehomepage.php");
        exit();
    }

    // Attempt to move the uploaded file to the target directory
    if (!move_uploaded_file($photo["tmp_name"], $targetFile)) {
        $_SESSION['errorMsg'] = "Sorry, there was an error uploading your file.";
        header("Location: candidatehomepage.php");
        exit();
    }

    // Check if the candidate already exists
    $checkQuery = "SELECT id FROM candidates WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing candidate
        $query = "UPDATE candidates SET description = ?, photo_path = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $description, $targetFile, $email);
    } else {
        // Insert new candidate
        $query = "INSERT INTO candidates (name, position, faculty, email, description, photo_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $_SESSION['user_name'], $_SESSION['user_position'], $_SESSION['user_faculty'], $email, $description, $targetFile);
    }

    if ($stmt->execute()) {
        $_SESSION['successMsg'] = "Profile updated successfully.";
        $_SESSION['showSuccess'] = true;
    } else {
        $_SESSION['errorMsg'] = "Error updating profile. Please try again.";
    }
    $stmt->close();
    $conn->close();
    header("Location: candidatehomepage.php");
    exit();
} else {
    header("Location: candidatehomepage.php");
    exit();
}
?>