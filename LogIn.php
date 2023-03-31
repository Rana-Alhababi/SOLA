<?php
session_start();
if (isset($_SESSION["role"])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="Images/sola.ico">
    <title>Admin's log-in</title>
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
        <li>Admin's Log In</li>
    </ul>

    <main>
        <div class="ManagerLog-inForm">
            <form action="LogInValidation.php" method="POST" class="form">
                <h1 class="title">Log in</h1>

                <div class="inputContainer">
                    <input type="text" class="input" placeholder="UserName" name="Manuser" required>
                    <label class="label">UserName</label>
                </div>
                <div class="inputContainer">
                    <input type="password" class="input" placeholder="Password" id="myInput" name="ManPass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                    <label class="label">Password</label>
                </div>
                <br>
                <input type="checkbox" onclick="hidePass();" >
                <span> Show Password </span> 

                <h4 style="color: #3f3f3f;">New Admin ? <a id="sign" href="SignUp.php" style="color: #3f3f3f;">Sign Up</a></h4>
                <input type="submit" name="submit" class="Button" onclick="LogIn();" value='Log in' style="color: #3f3f3f;"> 
             

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