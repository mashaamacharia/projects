<?php
session_start();
$user_id = $_SESSION['user_id'];
$reg_no = $_SESSION['reg_no'];
$name = $_SESSION['name'];
$faculty = $_SESSION['faculty'];
// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();

}

// Retrieve the faculty from the session
$userFaculty = $_SESSION['faculty'];
 // Debugging

// Your HTML and PHP code to display the homepage
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        label {
                width: 200px;
                display: block;
                 margin-bottom: 17px; /* Add some space between labels */
                 font-size: large;
            }

        label input[type="checkbox"] {
                 margin-left: 10px; /* Space between the name and checkbox */
                 vertical-align:middle;
                 font-size: large;
             }
        input[type="checkbox"] {
                  accent-color: #4CAF50; /* Green checkmark */
                  width: 20px;
                  height: 16px;
            }
            .logged-in-user {
                   color: blueviolet; /* Example color: Green */
                   font-weight: bold; /* Make it bold for emphasis */
                   margin-top: 10px; /* Add some space above if needed */
            }
            h5{
                    font-size: large;
                    font-family: 'Times New Roman', Times, serif;
                    color:black;
                    margin-left: 5vh;
             }
    


    </style>
      <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<body>
<script>
    const userFaculty = "<?php echo $_SESSION['faculty']; ?>";
</script>
    <div class="overlay"></div>
    <div class="container">
        <header>
        <img src="Images/chukalogo.jpeg" alt="chuka university Icon" class="icon">
        <h1>vote  your  voice !</h1>
        <p class="logged-in-user">Logged in as <?php echo htmlspecialchars($_SESSION['name']); ?></p>
        </header>
        <nav class="navbar">
            <button class="nav-toggle" aria-label="toggle navigation">
                <span class="hamburger"></span>
            </button>
            <ul class="nav-menu">
                <li><a href="contestants.php">Candidates</a></li>
                <li><a href="announcement.php">Announcements</a></li>
                <li><a href="results.php">Results</a></li>
                <li><a href="contacts.html">Contacts</a></li>
                <li><a href="donations.html">Donations</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <form method="POST" id="voting-form">
        <h5 class="animate__animated animate__heartBeat"> Click on the navigation bar for more options </h5> 
        <script>
        window.embeddedChatbotConfig = {
        chatbotId: "4hICQGiGAx0RAWJKUUC8Q",
        domain: "www.chatbase.co"
        }
        </script>
        <script
        src="https://www.chatbase.co/embed.min.js"
        chatbotId="4hICQGiGAx0RAWJKUUC8Q"
        domain="www.chatbase.co"
        defer>
        </script>
            <div class="row">
                <div class="position">
                    <h2>President</h2>
                    <div class="candidates" id="president-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
                <div class="position">
                    <h2>Deputy President</h2>
                    <div class="candidates" id="deputy-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
            </div>
            <div class="row">
         <?php if ($userFaculty): ?>
            <div class="position">
                    <h2>Faculty Rep (<?php echo htmlspecialchars($userFaculty); ?>)</h2>
                    <div class="candidates" id="faculty-rep-candidates">
                         <!-- Candidates will be populated dynamically here -->
                   </div>
           </div>
        <?php endif; ?>
                <div class="position">
                    <h2>Residence Rep</h2>
                    <div class="candidates" id="residence-rep-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
                <div class="position">
                    <h2>Non-Resident</h2>
                    <div class="candidates" id="non-resident-rep-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="position">
                    <h2>Environment Rep</h2>
                    <div class="candidates" id="environment-rep-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
                <div class="position">
                    <h2>Sports Rep</h2>
                    <div class="candidates" id="sports-rep-candidates">
                        <!-- Candidates will be populated dynamically here -->
                    </div>
                </div>
                <div class="position">
                    <!-- Empty div to maintain layout -->
                </div>
            </div>
            <div id="error-message" style="display: none; color: red; font-weight: bold; margin-top: 10px;"></div>
            <button type="submit">Submit Vote</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>