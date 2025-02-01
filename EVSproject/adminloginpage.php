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
    </header><div class="login-select">
        <select id="loginAs" class="login-dropdown" onchange="redirectUser()">
            <option value="" disabled selected>Login as...</option>
            <option value="student">Student</option>
            <option value="candidate">Candidate</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <form method="post" action="adminloginprocess.php">
        <br>
        <div>
           <label for="username">Username</label>
           <input type="text" id="username" name="username" required>
        </div>   
        <br> 
        <div>
           <label for="password">Password</label>
           <input type="password" id="password" name="password" required>
        </div> <br>
        <div>
           <label for="phone">Phone Number</label>
           <input type="password" id="phone" name="phone" required>
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
