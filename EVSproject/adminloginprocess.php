<?php
session_start();
$errorMsg = "";

// Include the database connection from config.php
include 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ? AND phone = ?");
    $stmt->bind_param("sss", $username, $password, $phone);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the credentials are correct
    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key in the 'login' table
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        // Redirect to the homepage
        header("Location: adminhomepage.php");
        exit();
    } else {
        $_SESSION['errorMsg'] = "Incorrect credentials. Please try again.";
        // Redirect back to the login page
        header("Location: adminloginpage.php");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}else {
    header("Location: candidateloginpage.php");
    exit();
}
?>
