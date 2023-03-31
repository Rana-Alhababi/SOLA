<?php
session_start();
if (isset($_SESSION["role"])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="Images/sola.ico">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="HF.css">
    <link rel="stylesheet" href="LogInSignUp.css">
    <script>
        function hidePass() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</head>

<body id="Jood">
    <header class="header">
        <img src="Images/logo.png" alt="logo" class="logo">
    </header>

    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li>Admin's Sign Up</li>
    </ul>


    <main>
        <div class="signupForm">
            <form action="SignUpValidation.php" method="POST" name="form" class="form">
                <h1 class="title">Sign Up</h1>

                <div class="inputContainer">
                    <input type="text" class="input" name="ID" placeholder="Manager's ID" pattern="[22\d]{8}"
                        title="22XXXXXX" required>
                    <label class="label">Admin's ID</label>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" name="Fname" placeholder="First Name" pattern="^[a-zA-Z]+$"
                        title="Letters only" required>
                    <label class="label">Admin's first Name</label>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" name="Lname" placeholder="Last Name" pattern="^[a-zA-Z]+$"
                        title="Letters only" required>
                    <label class="label">Admin's last Name</label>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" name="Uname" placeholder="User Name" pattern="^[a-zA-Z0-9._]+$"
                        title="Letters, dot, and underscore only" required>
                    <label class="label">Admin's User Name</label>
                </div>

                <div class="inputContainer">
                    <input type="password" class="input" name="Password" id="myInput" placeholder="Password"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                        required>
                    <label class="label">Password</label>
                </div>
                <br>
                <input type="checkbox" onclick="hidePass();">
                <span> Show Password </span>

                <h4 style="color: #3f3f3f;">Have an account ? <a id="sign" href="LogIn.php" style="color: #3f3f3f;">Log In</a></h4>
                <input type="submit" name="submit" class="Button" value='Sign up' style="color: #3f3f3f;">
            </form>
        </div>
    </main>

    <div class="Background"></div>
    <div class="Background B1"></div>
    <div class="Background B2"></div>

    <footer>
        <div class="h5">
            <h5>Get in touch</h5>
        </div>
        <aside class="aside">
            <a href="mailto:Sola@gmail.com" accesskey="n">Email</a>
        </aside>
    </footer>

</body>

</html>