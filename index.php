<?php
include 'ConnectDB.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="Images/sola.ico">
        <title>Home Page</title>
        <link rel="stylesheet" href="HF.css">
        <link rel="stylesheet" href="Home.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script>
            function search(name) {
                $.get("search.php", {name: name}, function (data) {

                    var obj = JSON.parse(data);

                    if (obj.length == 0) {
                        alert("salon not found");
                    } else {

                        var id = obj[0]['SID'];
                        var link = "SalonProfile.php?SID=" + id;
                        location.href = link;
                    }
                });
            }
        </script>
    </head>
    <body>

        <header class="header">
            <img id="logo" src="Images/logo.png" alt="logo" class="logo">

            <button id="switchM" accesskey="m" onclick="window.location.href = 'LogIn.php';"><span>Switch To
                    Manager</span></button> 

        </header>


        <ul class="breadcrumb">
            <li><a href="index.php" accesskey="a">Home</a></li>
        </ul>

        <main class="MainSalon">
            <br>
            <div class="flexbox">
                <div class="search">
                    <div>
                        <input type="text" placeholder="Search . . ." required onchange="search(this.value)">
                    </div>
                </div>
            </div>
            <br>
            <div class="Salons-container">
                <?php
                $sql = "SELECT * FROM SalonsList";
                $result = mysqli_query($connection, $sql);
                if (mysqli_num_rows($result) != 0)
                    while ($row = mysqli_fetch_assoc($result)) {
                        $Logo = $row['Logo'];
                        $Name = $row['Name'];
                        $Desc = $row['Description'];
                        $SID = $row['SID'];
                        echo '<div id="S">';
                        echo '<div class="row1 sal_row">';
                        echo '<div class="sa_img">';
                        echo '<img src="' . $Logo . '" alt="SalonLogo" class="S_img">';
                        echo '</div>';
                        echo '<div class="sa_elm">';
                        echo '<div class="desc">';
                        echo '<h2 class="salon-Name"> <a href="SalonProfile.php?SID=' . $SID . '">' . $Name . '</a></h2>';
                        echo '<p class="salon-desc">' . $Desc . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div> 
            <br>
            <br>
            <div class="Background"></div>
            <div class="Background B1"></div>
            <div class="Background B2"></div>
        </main>

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
