<?php
include 'ConnectDB.php';
session_start();
if (isset($_SESSION["role"])) {
    if (!($_SESSION["role"] == "Manager")) {
        echo '<script>window.location="index.php"; alert("You don\'t have access to the requested page!");</script>';
    }
} else {
    echo '<script>window.location="index.php"; alert("You don\'t have access to the requested page!, Please log in first.");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="Images/sola.ico">
        <title>Home Page Manager</title>
        <link rel="stylesheet" href="HF.css">
        <link rel="stylesheet" href="Home.css">
        <link rel="stylesheet" href="Admin.css">
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
            function openAdd() {
                document.getElementById("form-add").style.display = "block";
            }

            function closeAdd() {
                document.getElementById("form-add").style.display = "none";
            }
        </script>
    </head>

    <body>

        <header class="header">
            <img id="logo" src="Images/logo.png" alt="logo" class="logo">

            <button id="switchM" accesskey="m" onclick="window.location.href = 'WipeSession.php';"><span>Sign Out
                </span></button> 

        </header>



        <ul class="breadcrumb">
            <li><a href="manager_Home.php" accesskey="a">Home</a></li>
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
            <button class="open-button" onclick="openAdd();" style="width: 100%; color: #3f3f3f; text-decoration: underline;">Add Salon </button>
            <div class="form-add" id="form-add">
                <form class="add"  method="POST" action="Add_Salon.php" enctype="multipart/form-data" >
                    <fieldset>
                        <legend id="legend">Please fill Salon information details</legend>
                        <br />

                        <label class="inpLabel" for="name"> Enter Salon's Name:</label>
                        <input id="salonName" name="salonName" type="text" placeholder="Salon's Name" />

                        <br><label class="inpLabel" for="Description">Enter your request service description:</label>
                        <textarea id="Description" name="Description" rows="4" cols="30" ></textarea>


                        <br><br>
                        <label class="inpLabel" for="type">Select salon's services type:</label>
                        <br>
                        <div name="sertyp" id="sertyp" class="Select" >
                            <input name='addSer[]' class="addSer" type="checkbox" value='1'/>Nail care<br>
                            <input name='addSer[]' class="addSer" type="checkbox" value='2'/>Dye Hair <br>
                            <input name='addSer[]' class="addSer" type="checkbox" value='3'/>Lashes<br><br>
                        </div>

                        <!--  <lable class="addSer" value="Nail care">Nail care</lable> -->
                        <br>
                        <label class="inpLabel" for="Day">Select working Days:</label>
                        <br>
                        <div name="SelectDay" id="day" class="Select" >
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Sunday"    />Sunday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Monday"    />Monday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Tuesday"   />Tuesday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Wednesday"   />Wednesday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Thursday"   />Thursday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Friday"   />Friday <br>
                            <input for="days"  name="day[]" class="day" type="checkbox" value="Saturday"  />Saturday <br>

                            <br>
                        </div>

                        <label class="inpLabel" for="OpT">Enter opening time:</label>
                        <input  type="time" id="OpT" name="OpT"  >
                        <br>
                        <label class="inpLabel" for="clT">Enter closing time:</label>
                        <input  type="time" id="clT" name="clT" >

                        <br> <br>

                        <label class="inpLabel" for="loc">Enter Salon's loction URL:</label>
                        <input type="text" id="loc" name="loc" ></>

                        <br>
                        <label class="inpLabel" for="phone">Enter phone number:</label>
                        <input type="tel" id="phone" name="phone" placeholder="05xxxxxxx"
                               pattern="[05\d]{10}" >
                        <br>
                        <label class="inpLabel" for="fileToUpload">Upload salon's logo:</label>
                        <input type="file" id="fileToUpload" name="fileToUpload"  >

                        <br><br> 
                        
                        <button class="btn" type="submit" value="submitSalon" name="submitSalon" >submit</button>

                    </fieldset>
                </form>
            </div>
            <br>

            <div class="Salons-container">
                <?php
                include 'ConnectDB.php';
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

