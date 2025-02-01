<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="loginpage.css"> 
</head>
<body>
    <div class="overlay"></div> 
    <header>
        <img src="Images/chukalogo.jpeg" alt="chuka university Icon" class="icon">
    </header>
    
    <!-- Dropdown for login selection -->
    <div class="login-select">
        <select id="loginAs" class="login-dropdown" onchange="redirectUser()">
            <option value="" disabled selected>Login as...</option>
            <option value="student">Student</option>
            <option value="candidate">Candidate</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <h1> VOTE ! VOTE ! VOTE !</h1>
    <div class="fom">
    <form method="post" action="login.php">
        <br>
        <div>
           <label for="RegNo">RegNo</label>
           <input type="text" id="Registration" name="Registration"><br><br>
        </div>   
        <div>
            <label for="Faculty">Faculty</label>
            <select id="Faculty" name="Faculty" class="faculty-dropdown">
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
        </div> 
        <br> 
        <div>
           <label for="Idno">IdentityNo</label>
           <input type="password" id="IDNo" name="IDNo">
        </div>
        <br><br>
        <div>
            <input type="Submit" id="submit" name="Submit">
        </div> 
        <?php
        session_start();
        if (isset($_SESSION['errorMsg'])) {
            echo "<p style='color:red;font-weight:900px'>" . $_SESSION['errorMsg'] . "</p>";
            unset($_SESSION['errorMsg']);
        }
        ?>
    </form>
    </div>
    <footer>
        @Infinity <br>
        Free and Fair Elections <br>
    </footer>

    <script>
        function redirectUser() {
            var loginAs = document.getElementById("loginAs").value;
            if (loginAs === "student") {
                window.location.href = "loginpage.php";
            } else if (loginAs === "admin") {
                window.location.href = "adminloginpage.php";
            }
            else if (loginAs === "candidate") {
                window.location.href = "candidateloginpage.php";
            }
        }
    </script>
</body>
</html>
