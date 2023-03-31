<?php
error_reporting(0);
include "ConnectDB.php";
session_start();
$SID = $_GET['SID'];
$_SESSION['SID'] = $_GET['SID'];
//$SID = $_SESSION['SID'];
$submitReview = false;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="Images/sola.ico">
        <title>Salon's Profile</title>
        <link rel="stylesheet" href="HF.css">
        <link rel="stylesheet" href="admin.css">		
        <link rel="stylesheet" href="Salon's_Profile.css">
        <script src="Rating.js"></script>

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href='jquery-bar-rating-master/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="jquery-bar-rating-master/dist/jquery.barrating.min.js" type="text/javascript"></script>
        <script type="text/javascript">

            function openForm() {
                document.getElementById("ReviewForm").style.display = "block";
            }

            function openEdit() {
                document.getElementById("form-edit").style.display = "block";
            }

            function closeEdit() {
                document.getElementById("form-edit").style.display = "none";
            }

            function openForm2() {
                document.getElementById("RatingForm").style.display = "block";
            }

            function del(id) {
                var txt;
                if (confirm("Are You Sure?")) {
                    $.get("deleteSalon.php", {SID: id}, // data will be returend here 
                            function (data) { // then use data as a  parameter 
                                window.location.href = "manager_Home.php";
                            } // end finction
                    ); // end post
                }
            }

            $(function () {
                $('.rating').barrating({
                    theme: 'fontawesome-stars',
                    onSelect: function (value, text, event) {

                        // Get element id by data-id attribute
                        var el = this;
                        var el_id = el.$elem.data('id');
                        // rating was selected by a user
                        if (typeof (event) !== 'undefined') {
                            var split_id = el_id.split("_");
                            var title = split_id[1]; // postid

                            // AJAX Request
                            $.ajax({
                                url: 'rating_ajax.php',
                                type: 'post',
                                data: {title: title, rating: value, SID: <?php echo $SID; ?>},
                                dataType: 'json',
                                // if function successfull, Update average
                                success: function (data) {
                                    var average = data['averageRating'];
                                    $('#avgrating_' + title).text(average);
                                }
                            });
                        }
                    }
                });
            });
        </script>
    </head>

    <body id="Jood">
        <header class="header">
            <img src="Images/logo.png" alt="logo" class="logo">
        </header>

        <ul class="breadcrumb">
            <?php if (($_SESSION["role"] == "Manager")) { ?>
                <li><a href="manager_Home.php">Home</a></li>
                <?php
            }
            if (($_SESSION["role"] != "Manager")) {
                ?>
                <li><a href="index.php">Home</a></li>
            <?php } ?>
            <li>Salon's Profile</li>
        </ul>
        <main>
            <div class="Card1"> 

                <div class="Salon-name-Rating"> 
                    <?php
                    $SID = $_GET['SID'];
                    $sql = "SELECT * FROM SalonsList WHERE SID= $SID ";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $Logo = $row['Logo'];
                    $Name = $row['Name'];
                    $PhoneNubmer = $row['PhoneNubmer'];
                    $WorkingDays = $row['workingDays'];
                    $Service = $row['service'];
                    $OpenHour = $row['OpenHour'];
                    $CloseHour = $row['CloseHour'];
                    $Location = $row['Location'];
                    $Description = $row['Description'];
                    echo '<p class="Card1-title"> ' . $Name . ' </p>';
                    $query = "SELECT average FROM `Rating` WHERE SID='$SID'";
                    $avgresult = mysqli_query($connection, $query) or die(mysqli_error());
                    $averageRate = 0;
                    if (mysqli_num_rows($avgresult) != 0) {
                        while ($average = mysqli_fetch_array($avgresult))
                            $averageRate += $average['average'];
                        $averageRate = $averageRate / 5;
                        echo '<p class="Salon-Avg-rating">' . $averageRate . ' / 5</p>';
                    } else
                        echo '<p style=" width: 120px;" class="Salon-Avg-rating">No rating yet</p>';
                    echo '</div>';
                    echo '<br>';
                    echo '<br>';
                    echo '<div class="Card1-display">';
                    echo '<div class="Text">';
                    echo '<div class="AboutSalon">';
                    echo '<p class="Headings" style="font-size: 40px;"> --About the salon-- </p>';
                    echo '<br>';
                    echo '<div class="Description">';
                    echo '<p class="Headings">Description: </p><p class="subText">' . $Description . '</p>';
                    echo '<br>';
                    echo '</div>';
                    echo '<hr class="divider" style="margin-left: 45px;">';
                    echo '<div class="category-PhoneNumber">';
                    echo '<div class="category">';
                    $countS = 0;
                    if (strpos($Service, '1') !== false)
                        $countS++;
                    if (strpos($Service, '2') !== false)
                        $countS++;
                    if (strpos($Service, '3') !== false)
                        $countS++;
                    if ($countS === 1)
                        echo '<p class="Headings">Salon\'s category: </p><p class="subText"> Silver </p>';
                    else if ($countS === 2)
                        echo '<p class="Headings">Salon\'s category: </p><p class="subText"> Gold </p>';
                    else if ($countS === 3)
                        echo '<p class="Headings">Salon\'s category: </p><p class="subText"> Platinum </p>';
                    echo '</div>';
                    echo '<div class="PhoneNumber">';
                    echo '<p class="Headings">Contact: </p>';
                    $PhoneNubmer = "0" . $PhoneNubmer;
                    echo '<p class="subText">' . $PhoneNubmer . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr class="divider" style="margin-left: 45px;">';
                    echo '<div class="Services-Hours">';
                    echo '<div class="Services">';
                    echo '<p class="Headings"> Available services: </p>';
                    echo '<p class="subText">';
                    if (strpos($Service, '1') !== false)
                        echo '- Nail care <br>';
                    if (strpos($Service, '2') !== false)
                        echo '- Hair dye <br>';
                    if (strpos($Service, '3') !== false)
                        echo '- Lashes <br>';
                    echo '</p>';
                    echo '</div>';
                    echo '<hr style="border-style: hidden; margin-right: 100px;">';
                    echo '<div class="Hours">';
                    echo '<p class="Headings">Working days:</p>';
                    echo '<p class="subText">';
                    if (strpos($WorkingDays, 'Sunday') !== false) {
                        echo '-Sunday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Monday') !== false) {
                        echo '-Monday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Tuesday') !== false) {
                        echo '-Tuesday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Wednesday') !== false) {
                        echo '-Wednesday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Thursday') !== false) {
                        echo '-Thursday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Friday') !== false) {
                        echo '-Friday <br>';
                        echo $OpenHour . ' - ' . $CloseHour . '<br>';
                    }
                    if (strpos($WorkingDays, 'Saturday') !== false) {
                        echo '-Saturday <br>';
                        echo $OpenHour . ' - ' . $CloseHour;
                    }
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    //echo '<br>';
                    echo '<hr class="divider" style="margin-left: 45px;">';
                    echo '<br>';
                    echo '<a target="_blank" class="subText" href=' . $Location . '>Click Here to See The Location</a>';
                    echo '</div>';
                    ?>

                </div>

                <?php if (($_SESSION["role"] == "Manager")) { ?>
                    <div class="Admin-only">
                        <button class="open-button" onclick="openEdit();">Edit Salon</button>
                        <button id="del" class="open-button" value="delete" onclick="del(<?php echo $SID; ?>)">Delete Salon</button>
                    </div>	
                <?php }
                ?>
            </div>
            <div class="form-edit" id="form-edit">
                <form action="EditSalon.php" method="POST" enctype="multipart/form-data" class="edit">
                    <fieldset>

                        <legend id="legend">Please fill Salon information details</legend>
                        <br />
                        <label class="inpLabel" for="name"> Enter Salon's Name:</label>
                        <input type="text" name="salonName" placeholder="Salon's Name" value="<?php echo $Name ?>" />
                        <input type="hidden" name="id"  value="<?php echo $SID; ?>" />

                        <br><label class="inpLabel" for="Description">Enter your request service description:</label>
                        <textarea id="Description" name="Description" rows="4" cols="30" value="vanilla"><?php echo $Description; ?></textarea>

                        <br><br>
                        <label class="inpLabel" for="type">Select salon's services type:</label>
                        <br>
                        <div class="Select" id="serviceType">
                            <?php
                            $CheckBoxNail = $CheckBoxHair = $CheckBoxLashes = '';
                            $Service = explode(',', $Service);
                            if (in_array('1', $Service)):
                                $CheckBoxNail = 'checked';
                            endif;
                            if (in_array('2', $Service)):
                                $CheckBoxHair = 'checked';
                            endif;
                            if (in_array('3', $Service)):
                                $CheckBoxLashes = 'checked';
                            endif;
                            ?>
                            <input name="addSer[]" class="addSer" value="1" type="checkbox" <?php echo $CheckBoxNail; ?>/>
                            <lable class="addSer" value="Nail care">Nail care</lable>

                            <br>
                            <input name="addSer[]" class="addSer" value="2" type="checkbox" <?php echo $CheckBoxHair; ?>/>
                            <lable class="addSer" value="Hair dye">Hair dye</lable>
                            <br>
                            <input name="addSer[]" class="addSer" value="3" type="checkbox" <?php echo $CheckBoxLashes; ?>/>
                            <label class="addSer" value="Lashes">Lashes</label>
                            <br><br>
                        </div>

                        <label class="inpLabel" for="hour">Select working Days:</label>
                        <br>

                        <div class="Select" id="day">      
                            <?php
                            $Sunday_ = $Monday_ = $Tuesday_ = $Wednesday_ = $Thursday_ = $Friday_ = $Saturday_ = '';

                            $WorkingDays_ex = explode(',', $WorkingDays);
                            if (in_array('Sunday', $WorkingDays_ex)):
                                $Sunday_ = 'checked';
                            endif;
                            if (in_array('Monday', $WorkingDays_ex)):
                                $Monday_ = 'checked';
                            endif;
                            if (in_array('Tuesday', $WorkingDays_ex)):
                                $Tuesday_ = 'checked';
                            endif;
                            if (in_array('Wednesday', $WorkingDays_ex)):
                                $Wednesday_ = 'checked';
                            endif;
                            if (in_array('Thursday', $WorkingDays_ex)):
                                $Thursday_ = 'checked';
                            endif;
                            if (in_array('Friday', $WorkingDays_ex)):
                                $Friday_ = 'checked';
                            endif;
                            if (in_array('Saturday', $WorkingDays_ex)):
                                $Saturday_ = 'checked';
                            endif;
                            ?>
                            <input name="days[]" class="days" value="Sunday"  type="checkbox" <?php echo $Sunday_; ?>/>
                            <lable class="days" value="Monday">Sunday</lable>
                            <br>
                            <input name="days[]" class="days" value="Monday" type="checkbox" <?php echo $Monday_; ?>/>
                            <lable class="days" value="Monday">Monday</lable>
                            <br>
                            <input name="days[]" class="days" value="Tuesday" type="checkbox" <?php echo $Tuesday_; ?>/>
                            <label class="days" value="Tuesday">Tuesday</label>
                            <br>
                            <input name="days[]" class="days" value="Wednesday" type="checkbox" <?php echo $Wednesday_; ?>/>
                            <label class="days" value="Wednesday">Wednesday</label>
                            <br>
                            <input name="days[]" class="days" value="Thursday" type="checkbox" <?php echo $Thursday_; ?>/>
                            <label class="days" value="Thursday">Thursday</label>
                            <br>
                            <input name="days[]" class="days" value="Friday" type="checkbox" <?php echo $Friday_; ?>/>
                            <label class="days" value="Friday">Friday</label>
                            <br>
                            <input name="days[]" class="days" value="Saturday" type="checkbox" <?php echo $Saturday_; ?>/>
                            <label class="days" value="Saturday">Saturday</label>
                            <br><br>
                        </div>

                        <label class="inpLabel" for="OpT">Enter opening time:</label>
                        <input type="time" id="OpT" value="<?php echo $OpenHour; ?>" name="OpT">
                        <br>
                        <label class="inpLabel" for="clT">Enter closing time:</label>
                        <input type="time" id="clT" value="<?php echo $CloseHour; ?>" name="clT">

                        <br><br>

                        <label class="inpLabel" for="loc">Enter Salon's loction:</label>
                        <input type="url" id="loc" name="loc" value="<?php echo $Location; ?>" ></>
                        <br><br>

                        <label class="inpLabel" for="phone">Enter phone number:</label>
                        <input type="tel" id="phone" name="phone" placeholder="05xxxxxxx"  pattern="[05\d]{10}" value="<?php echo $PhoneNubmer ?>" required ><br><br>

                        <label class="inpLabel" for="fileToUpload">Upload salon's logo:</label>
                        <input type="file" id="fileToUpload" name="fileToUpload"  >
                        <br> 

                        <button class="btn" type="submit" value="submit_update" name="submit_update">update</button>
                    </fieldset>
                </form>
            </div>		
            <div class="Card2">
                <div class="Salon-Ratings">
                    <p class="Card2-title"> Salon's Rating: </p>
                    <div class="Aspects">
                        <div class="Aspects-text">
                            <p class="subText" style="font-size: 1.2em; line-height: 2;">scheduling appointment:</p>
                            <p class="subText" style="font-size: 1.2em; line-height: 2;">value to service:</p>
                            <p class="subText" style="font-size: 1.2em; line-height: 2;">service:</p>
                            <p class="subText" style="font-size: 1.2em; line-height: 2;">customer care:</p>
                            <p class="subText" style="font-size: 1.2em; line-height: 2;">product quality:</p>

                        </div>
                        <div class="Aspects-Rating">
                            <?php
                            $query1 = "SELECT * FROM Rating WHERE title='scheduling appointment:' AND SID=$SID";
                            $avgresult1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($avgresult1) != 0) {
                                while ($average = mysqli_fetch_array($avgresult1))
                                    $AvRate = $average['average'];
                                echo '<p>';
                                for ($count = 0; $count < $AvRate; $count++)
                                    echo '★';
                                for ($count = $AvRate; $count < 5; $count++)
                                    echo '☆';
                                echo '</p>';
                            } else
                                echo '<p>No rating yet</p>';
                            $query1 = "SELECT * FROM Rating WHERE title='value to service:' AND SID=$SID";
                            $avgresult1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($avgresult1) != 0) {
                                while ($average = mysqli_fetch_array($avgresult1))
                                    $AvRate = $average['average'];
                                echo '<p>';
                                for ($count = 0; $count < $AvRate; $count++)
                                    echo '★';
                                for ($count = $AvRate; $count < 5; $count++)
                                    echo '☆';
                                echo '</p>';
                            } else
                                echo '<p>No rating yet</p>';
                            $query1 = "SELECT * FROM Rating WHERE title='service:' AND SID=$SID";
                            $avgresult1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($avgresult1) != 0) {
                                while ($average = mysqli_fetch_array($avgresult1))
                                    $AvRate = $average['average'];
                                echo '<p>';
                                for ($count = 0; $count < $AvRate; $count++)
                                    echo '★';
                                for ($count = $AvRate; $count < 5; $count++)
                                    echo '☆';
                                echo '</p>';
                            } else
                                echo '<p>No rating yet</p>';
                            $query1 = "SELECT * FROM Rating WHERE title='customer care:' AND SID=$SID";
                            $avgresult1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($avgresult1) != 0) {
                                while ($average = mysqli_fetch_array($avgresult1))
                                    $AvRate = $average['average'];
                                echo '<p>';
                                for ($count = 0; $count < $AvRate; $count++)
                                    echo '★';
                                for ($count = $AvRate; $count < 5; $count++)
                                    echo '☆';
                                echo '</p>';
                            } else
                                echo '<p>No rating yet</p>';
                            $query1 = "SELECT * FROM Rating WHERE title='product quality:' AND SID=$SID";
                            $avgresult1 = mysqli_query($connection, $query1);
                            if (mysqli_num_rows($avgresult1) != 0) {
                                while ($average = mysqli_fetch_array($avgresult1))
                                    $AvRate = $average['average'];
                                echo '<p>';
                                for ($count = 0; $count < $AvRate; $count++)
                                    echo '★';
                                for ($count = $AvRate; $count < 5; $count++)
                                    echo '☆';
                                echo '</p>';
                            } else
                                echo '<p>No rating yet</p>';
                            ?>
                        </div>
                    </div>
                </div>
                <?php if (($_SESSION["role"] != "Manager")) { ?>
                    <div class="RR-buttons">
                        <button onclick="openForm()" class="Review-button">+Add Review</button>
                        <button onclick="openForm2()" class="Rate-button">+Add Rating</button>
                    </div>
                <?php }
                ?>

            </div>
            <div class="add-edit"> 
                <div class="form-popup" id="ReviewForm">
                    <?php
                    echo '<form action="AddReview.php?SID=' . $SID . '" class="form-container" method="POST">';
                    ?>
                    <fieldset>
                        <legend id="legend">Please fill your review details</legend>
                        <input type="hidden" name="id"  value="<?php echo $SID; ?>" />

                        <br>
                        <label for="type" placeholder="">Select your request service type:</label>

                        <div name="serviceType" id="addSer" class="Select">
                            <input name='addSer[]' class="addSer" type="checkbox" value='1'/>Nail care<br>
                            <input name='addSer[]' class="addSer" type="checkbox" value='2'/>Dye Hair <br>
                            <input name='addSer[]' class="addSer" type="checkbox" value='3'/>Lashes<br><br>
                        </div>
                        <br><br>
                        <label for="rev">Review your service:</label>
                        <br>
                        <textarea id="rev" name="rev" placeholder="description" rows="4" cols="30" ></textarea>
                        <br><br>

                        <button class="btn" type="submit" value="submitReview" name="submitReview" >submit</button>
                    </fieldset>
                    </form>
                </div>

                <div class="form-popup2" id="RatingForm">
                    <!-- Adding rating by selecting service type and rate service using stars in PHP, AJAX  -->
                    <?php
                    echo '<form action="SalonProfile.php?SID=' . $SID . '" class="form-container2" method="POST" >';
                    ?>
                    <fieldset class="fldst">
                        <legend id="legend">Please, Rate your service:</legend>
                        <br>
                        <div class="content">
                            <?php
                            // select each title and its ID (scheduling appointment, service, value to service, customer care, product quality) and each will have its stars  
                            $titleArray = ['scheduling appointment:', 'value to service:', 'service:', 'customer care:', 'product quality:'];
                            for ($i = 0; $i < 5; $i++) {
                                $title = $titleArray[$i];
                                ?>
                                <div class="post">
                                    <h4><?php echo $title ?></h4>
                                    <div class="post-action">
                                        <!-- Rating stars -->
                                        <select class='rating' id='rating_<?php echo $title; ?>' data-id='rating_<?php echo $title; ?>'>
                                            <option value="1" >1</option>
                                            <option value="2" >2</option>
                                            <option value="3" >3</option>
                                            <option value="4" >4</option>
                                            <option value="5" >5</option>
                                        </select>
                                        <div style='clear: both;'></div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <button class="btn" type="submit" value="closeRating"  name="closeRating" >cancel Rating</button> 
                            <button class="btn" type="submit" value="submitRating" name="submitRating">Submit Rating</button> 
                        </div>
                    </fieldset>
                    </form>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitRating'])) { // user submit the rating, check if user rate all aspects
                $query = "SELECT MIN(count) As min FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $min = $fetch['min'];

                $query = "SELECT MAX(count) As max FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $max = $fetch['max'];

                $query = "SELECT COUNT(count) As Counter FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $counter = $fetch['Counter'];

                if ($min != $max || $counter != 5) { // user did not rate all aspects, delete last rating that have Max
                    echo '<script>  alert("Error, Please Rate All Rating aspects")</script> ';
                    echo '<script> document.getElementById("RatingForm").style.display = "none" </script> ';
                    $titleArray = ['scheduling appointment:', 'value to service:', 'service:', 'customer care:', 'product quality:'];

                    for ($i = 0; $i < 5; $i++) { // Deleting Extra rating
                        $title = $titleArray[$i];
                        $query = "SELECT * FROM `Rating` WHERE `SID`='$SID' and title='$title' ";
                        $result = mysqli_query($connection, $query);
                        $fetch = mysqli_fetch_assoc($result);
                        $count = $fetch['count'];
                        $prev = $fetch['PreviousRating'];
                        $total = $fetch['total'];
                        $rating = $fetch['rating'];

                        if ($count == $max) { // Delete the extra rating
                            if ($count == 1) { // if its the first, Delete it
                                $query = "DELETE FROM `Rating` WHERE `SID`='$SID' and title='$title' ";
                                $result = mysqli_query($connection, $query);
                            } else { // not the first but extra
                                $total = $total - $rating;
                                $count = $count - 1;
                                $avg = $total / $count;
                                $avg = round($avg);

                                $updatequery = "UPDATE `Rating` SET rating='$prev', total='$total', count='$count',average='$avg' WHERE title='$title' and SID='$SID'";
                                $result = mysqli_query($connection, $updatequery);
                            }
                        }
                    }
                } else { // user rate all aspects, add rating correctly
                    echo '<script>  alert("Your Rating added successfully")</script> ';
                }
                echo '<script> document.getElementById("RatingForm").style.display = "none" </script> ';
                echo '<script>document.location.reload(true)</script> ';
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['closeRating'])) {

                /* case1: cancel empty, do nothing
                 * case2: cancel some and some Done
                 * case3: cancel after 5 rating Done delete the case (rare to happen)
                 */
                $titleArray = ['scheduling appointment:', 'value to service:', 'service:', 'customer care:', 'product quality:'];

                $query = "SELECT MIN(count) As min FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $min = $fetch['min'];

                $query = "SELECT MAX(count) As max FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $max = $fetch['max'];

                $query = "SELECT COUNT(count) As Counter FROM `Rating` WHERE `SID`='$SID'";
                $result = mysqli_query($connection, $query);
                $fetch = mysqli_fetch_assoc($result);
                $counter = $fetch['Counter'];

                if ($max != $min || $counter != 5) {  // enter when there is no differences
                    for ($i = 0; $i < 5; $i++) {
                        $title = $titleArray[$i];
                        $query = "SELECT * FROM `Rating` WHERE `SID`='$SID' and title='$title' ";
                        $result = mysqli_query($connection, $query);
                        $fetch = mysqli_fetch_assoc($result);
                        $count = $fetch['count'];
                        $prev = $fetch['PreviousRating'];
                        $total = $fetch['total'];
                        $rating = $fetch['rating'];

                        if ($count == $max) {// enter when there are rates count more than other
                            if ($count == 1) {
                                $query = "DELETE FROM `Rating` WHERE `SID`='$SID' and title='$title' ";
                                $result = mysqli_query($connection, $query);
                                
                            } else { // enter when count above 1, need to uupdate
                                $count = $count - 1;
                                $total = $total - $rating;
                                $avg = $total / $count;
                                $avg = round($avg);
                                $updatequery = "UPDATE `Rating` SET rating='$prev', total='$total', count='$count',average='$avg' WHERE title='$title' and SID='$SID'";
                                $result = mysqli_query($connection, $updatequery);
                            }
                        }
                    }
                }
                echo '<script>  alert("Your Rating canceled")</script> ';
                echo '<script> document.getElementById("RatingForm").style.display = "none" </script> ';
                echo '<script>document.location.reload(true)</script> ';
            }
            ?>
            <p class="Headings" style="display: flex; margin-left: 200px; font-size: 3em;">Reviews: </p>
            <div class="Card3">
                <?php
                $sql1 = "SELECT * FROM Review WHERE SID=$SID";
                $result = mysqli_query($connection, $sql1);
                if (mysqli_num_rows($result) != 0)
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ser = $row['service'];
                        echo '<div class="Card-comment">';
                        echo '<div class="User-Info">';
                        echo '<img src="images/icon.png" alt="User Logo" class="User-Logo">';
                        echo '<p class="UserNameUnknown"> User: </p>';
                        echo '</div>';
                        echo '<div class="Comment">';
                        echo '<p class="User-Comment">' . $row['Description'] . '</p>';
                        echo '</div>';
                        echo '<div class="Services-Took">';
                        if (strpos($ser, '1') !== false)
                            echo '<p class="UserService">Nail Care</p>';
                        if (strpos($ser, '2') !== false)
                            echo '<p class="UserService">Hair Dye</p>';
                        if (strpos($ser, '3') !== false)
                            echo '<p class="UserService">Lashes</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
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