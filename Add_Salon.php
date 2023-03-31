<?php
include 'ConnectDB.php';
session_start();
$File='';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitSalon'])) {
//checking facilities

    if (empty($_POST['salonName']) || empty($_POST['addSer']) || empty($_POST['day']) || empty($_POST['OpT']) || empty($_POST['clT']) || empty($_POST['loc']) || empty($_POST['phone']) || empty($_POST['Description']) || !(is_uploaded_file($_FILES["fileToUpload"]["tmp_name"]))) {
        $Day = "";
        $count = -1;
        if (isset($_POST['day'])){
        foreach ($_POST['day'] as $key => $value)
            $count++;
        if ($count == 0)
            $Day = $value;

        if ($count > 0) {
            $Day = $_POST['day'][0];

            for ($index = 1; $index <= $count; $index++) {
                $Day = $Day . "," . $_POST['day'][$index];
            }
        }
        }
        echo '<script> alert("error, fill the form correctly")</script> ' . "<br>";
        echo '<script> location.href="manager_Home.php"</script>';
    } else {
        echo '<script> document.getElementById("form-add").style.display = "none"; </script>';

        $maxID = "SELECT MAX(SID) FROM `SalonsList`";
        $maxID = mysqli_query($connection, $maxID);
        $maxID = mysqli_fetch_assoc($maxID);
        foreach ($maxID as $maxID)
            $maxID++;

        $SalonName = $_POST['salonName'];
        $close = $_POST['clT'];
        $open = $_POST['OpT'];
        $loc = $_POST['loc'];
        $phone = $_POST['phone'];
        $Description = $_POST['Description'];

        $Day = "";
        $count = -1;
        foreach ($_POST['day'] as $key => $value)
            $count++;
        if ($count == 0)
            $Day = $value;



        if ($count > 0) {
            $Day = $_POST['day'][0];

            for ($index = 1; $index <= $count; $index++) {
                $Day = $Day . "," . $_POST['day'][$index];
            }
        }

        $service = "";
        $count = -1;
        foreach ($_POST['addSer'] as $key => $value)
            $count++;
        if ($count == 0)
            $service = $value;



        if ($count > 0) {
            $service = $_POST['addSer'][0];

            for ($index = 1; $index <= $count; $index++) {
                $service = $service . "," . $_POST['addSer'][$index];
            }
        }

        // create DIRECTORY
        $uploadDir = 'uploads';
        if (!is_dir($uploadDir)) { // check if Directory exist or no
            umask(mask);
            mkdir($uploadDir, 0775);
        }

        // allowed files type
        function canupload($fileType) {
            $allowedFile = ['jpg',
                'jpeg',
                'png',
            ];

            if (in_array($fileType, $allowedFile))
                return true;
            else
                return false;
        }

// end of function
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {   // check filled in the form without error
            $fi = $_FILES['fileToUpload']['name'];
            $ext = pathinfo($fi, PATHINFO_EXTENSION);

            $canupload = canupload($ext);
            if ($canupload) {
                // find file name, location, and move it to server
                $FileName = $_FILES['fileToUpload']['name'];
                $file_location = $uploadDir . '/' . $FileName;
                $movFile = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_location);
                $File=true;
                
            }
        }
if ($File){
        $sql = "INSERT INTO `SalonsList`(`SID`, `Name`, `Location`, `Description`, `PhoneNubmer`, `WorkingDays`, `OpenHour`, `CloseHour`, `Logo`, `Service`) VALUES ('$maxID','$SalonName','$loc','$Description','$phone','$Day','$open','$close','$file_location','$service')";
        $co = mysqli_query($connection, $sql);
        echo "<script>alert('Salon added Successfuly')</script>";
        echo '<script> location.href="SalonProfile.php?SID='.$maxID.'"</script>';
}
else {
        echo "<script>alert('Error, only Image allowed in Logo')</script>";
        echo '<script> location.href="manager_Home.php?"</script>';
}
    }
}


?>