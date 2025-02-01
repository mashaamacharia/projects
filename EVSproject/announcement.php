<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link rel="stylesheet" href="announcement.css"> <!-- Linking the external CSS file -->
</head>
<body>
    <div class="overlay"></div>
    <?php
    include 'connection.php'; // Database connection file

    // Fetch announcements
    $query = "SELECT announcement, DATE_FORMAT(posted_at, '%M %d, %Y') AS posted_date FROM announcements ORDER BY posted_at DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error fetching announcements: " . mysqli_error($conn);
    } else {
        echo "<div class='announcements-container'>";
        echo "<header>
            <img src='Images/chukalogo.jpeg' alt='chuka university Icon' class='icon'>
            <h2>Announcements</h2>
        </header>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='announcement-box'>";
            echo "<p class='date-posted'>" . $row['posted_date'] . "</p>";
            echo "<p class='announcement-text'>" . $row['announcement'] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    }
    ?>
</body>
</html>
