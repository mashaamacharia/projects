<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Forms</title>
    <link rel="stylesheet" href="adminhomepage.css">

</head>
<body>
    <div class="overlay"></div>
    <a href="logout.php" class="logout-button">Logout</a>
    <div class="container">
        <button id="registerBtn" class="styled-button">Register Candidate</button>
        <button id="announceBtn" class="styled-button">Make Announcements</button>

        <form id="registerForm" class="form" style="display: none;">
        <header>
            <img src="Images/chukalogo.jpeg" alt="chuka university Icon" class="icon">
            <h2>Register Candidate</h2>
       </header>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="position">Position:</label>
            <select id="position" name="position"  required>
                <option value="" disabled selected>Choose position...</option>
                <option value="president">President</option>
                <option value="deputy">Deputy president</option>
                <option value="faculty-rep">Faculty-Rep</option>
                <option value="resident-rep">Resident-Rep</option>
                <option value="non-resident-rep">Non-Resident</option>
                <option value="environment-rep">Environment-Rep</option>
                <option value="sports-rep">Sports-Rep</option>
            </select>
            <label for="faculty">Faculty:</label>
            <select id="faculty" name="faculty" required>
                <option value="" disabled selected>Choose faculty...</option>
                <option value="Science & Tech">Science & Tech</option>
                <option value="Law">Law</option>
                <option value="Agriculture">Agriculture</option>
                <option value="Business">Business</option>
                <option value="Engineering">Engineering</option>
                <option value="Education">Education</option>
                <option value="Environment">Environment</option>
                <option value="Humanities">Humanities</option>
                <option value="Nursing">Nursing</option>
            </select>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Register</button>
            <div id="registerMessage" class="message-area"></div>
        </form>

        <form id="announcementForm" class="form" style="display: none;">
        <header>
            <img src="Images/chukalogo.jpeg" alt="chuka university Icon" class="icon">
            <h2>Make Announcements</h2>
       </header>
            <label for="announcement">Announcement:</label>
            <textarea id="announcement" name="announcement" required></textarea>
            <button type="submit">Post</button> <!-- <button type="button" class="delete-btn" onclick="deleteAnnouncement()">Delete</button> Added Delete button -->
            <div id="announcementMessage" class="message-area"></div>
        </form>
        <div id="message" class="message">
            
        </div>
    </div>

    <script src="adminscript.js"></script>

</body>
</html>
