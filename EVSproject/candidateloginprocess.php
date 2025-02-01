<?php
session_start();
include 'connection.php'; // Adjust this line to your actual database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $registration = filter_input(INPUT_POST, 'Registration', FILTER_SANITIZE_STRING);
    $idNo = filter_input(INPUT_POST, 'IDNo', FILTER_SANITIZE_STRING);

    if (!$email || !$registration || !$idNo) {
        $_SESSION['errorMsg'] = "All fields are required.";
        header("Location: candidateloginpage.php");
        exit();
    }

    $query = "SELECT d.*, c.id as candidate_id, c.name, c.position, c.faculty 
              FROM details d 
              LEFT JOIN candidates c ON d.email = c.email 
              WHERE d.email = ? AND d.Registration = ? AND d.IDNo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $email, $registration, $idNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Candidate found, grant access
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['last_activity'] = time();

        // Generate and store a unique session token
        $_SESSION['session_token'] = bin2hex(random_bytes(32));

        header("Location: candidatehomepage.php");
    } else {
        // Candidate not found, return to login with error
        $_SESSION['errorMsg'] = "Invalid credentials.";
        header("Location: candidateloginpage.php");
    }

    $stmt->close();
} else {
    header("Location: candidateloginpage.php");
}

$conn->close();
exit();
?>