<?php
session_start();
$errorMsg = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $registration = $_POST['Registration'];
    $faculty = $_POST['Faculty'];
    $idNo = $_POST['IDNo'];

    // Database connection details
    $servername = "localhost"; // Change if necessary
    $username = "root"; // Change if necessary
    $password = ""; // Change if necessary
    $dbname = "chuka";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM login WHERE Registration = ? AND IDNo = ? AND Faculty = ?");
    $stmt->bind_param("sss", $registration, $idNo, $faculty);

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
        $_SESSION['reg_no'] = $user['Registration'];
        $_SESSION['faculty']= $user['Faculty'];
        $_SESSION['name']= $user['Name'];
        // Redirect to the homepage
        header("Location: homepage.php");
        exit();
    } else {
        $_SESSION['errorMsg'] = "Incorrect credentials. Please try again.";
        // Redirect back to the login page
        header("Location: loginpage.php");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}else {
    header("Location: loginpage.php");
    exit();
}
?>
