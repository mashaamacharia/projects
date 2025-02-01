<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: candidateloginpage.php");
    exit();
}

// Display user information
 htmlspecialchars($_SESSION['user_email']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Candidate Homepage</title>
    <link rel="stylesheet" href="candidatehomepage.css">
  
</head>
<body>
    <div class="overlay"></div>
    <a href="logout.php" class="logout-button">Logout</a>
    <h1>Candidate Profile</h1>
    <form id="candidateForm" action="candidate_data.php" method="POST" enctype="multipart/form-data">
        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>
        <div class="image-preview-container">
            <img id="imagePreview" alt="Image preview" />
        </div>
        
        <label for="description">Description (max 230 characters):</label>
        <textarea id="description" name="description" maxlength="230" required></textarea>
        <div id="charCount">0 / 230</div>
        
        <div class="button-group">
            <button type="submit">Upload</button>
            <button type="button" onclick="showResetConfirmation()">Reset</button>
        </div>
        
        <?php
if (isset($_SESSION['successMsg'])) {
    echo '<div class="message success">' . htmlspecialchars($_SESSION['successMsg']) . '</div>';
    unset($_SESSION['successMsg']);
}
if (isset($_SESSION['errorMsg'])) {
    echo '<div class="message error">' . htmlspecialchars($_SESSION['errorMsg']) . '</div>';
    unset($_SESSION['errorMsg']);
}
?>

        
    </form>

    <div id="resetModal" class="modal">
        <div class="modal-content">
            <p>Do you really want to reset the fields?</p>
            <div class="modal-buttons">
                <button onclick="resetForm()">Yes</button>
                <button onclick="hideResetConfirmation()">No</button>
            </div>
        </div>
    </div>
    <div id="inactivityModal" class="inactivity-modal">
        <div class="inactivity-modal-content">
            <h2>Session Expired</h2>
            <p>You have been logged out due to inactivity.</p>
            <button onclick="logout()";>OK</button>
        </div>
    </div>
    <script src="candi.js"></script>
    
</body>
</html>