<?php

error_reporting(0);
include "ConnectDB.php";
session_start();
$canupload='';
 $SID = $_POST['id'];

//echo $Day;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_update'])) {

    $Salon_Name = $Salon_Type = $Salon_Time = $folder = $Salon_Open_Time = $Salon_Close_Time = $Salon_Location = $Salon_Phone_Number = '';

    $ERROR_MSG = array();
    $SUCCESS_MSG = array();
   
    if (!empty($_POST['salonName'])) {
        $Salon_Name = mysqli_real_escape_string($connection, $_POST['salonName']);
    }
    if (!empty($_POST['addSer'])) {
        foreach ($_POST['addSer'] as $type) {
            $Selected_Type[] = $type;
        }

        $Salon_Type = implode(',', $Selected_Type);
        $Salon_Type = mysqli_real_escape_string($connection, $Salon_Type);
    }
    if (!empty($_POST['days'])) {

        foreach ($_POST['days'] as $Day) {
            $Selected_Days[] = $Day;
        }

        $Salon_Time = implode(',', $Selected_Days);
        $Salon_Time = mysqli_real_escape_string($connection, $Salon_Time);
    }
    $Salon_Open_Time = mysqli_real_escape_string($connection, $_POST['OpT']);
    $Salon_Close_Time = mysqli_real_escape_string($connection, $_POST['clT']);
    $Salon_Location = mysqli_real_escape_string($connection, $_POST['loc']);
    $Salon_Phone_Number = mysqli_real_escape_string($connection, $_POST['phone']);
    $Salon_Description = mysqli_real_escape_string($connection, $_POST['Description']);
    if (empty($Salon_Name)) {
        $ERROR_MSG[] = 'Salon Name is Required';
    }
    if (empty($Salon_Description)) {
        $ERROR_MSG[] = 'Salon Description is Required';
    }
    if (empty($Salon_Type)) {
        $ERROR_MSG[] = 'Salon Type is Required';
    }
    if (empty($Salon_Time)) {
        $ERROR_MSG[] = 'Salon working Days is Required';
    }
    if (empty($Salon_Open_Time)) {
        $ERROR_MSG[] = 'Salon Open Time is Required';
    }
    if (empty($Salon_Close_Time)) {
        $ERROR_MSG[] = 'Salon Close Time is Required';
    }
    if (empty($Salon_Location)) {
        $ERROR_MSG[] = 'Salon Location is Required';
    }
    if (empty($Salon_Phone_Number)) {
        $ERROR_MSG[] = 'Salon Phone Number is Required';
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
            else 
                $ERROR_MSG[] = 'only image extention are allowed(PNG, JPEG, jpg)';
        }else
             $File=false;
            
        
    if (empty($ERROR_MSG)) {
        if ($File)
          $SQL_upp = "UPDATE `salonslist` SET Name='$Salon_Name', Description='$Salon_Description', Location='$Salon_Location', PhoneNubmer='$Salon_Phone_Number', workingDays='$Salon_Time', OpenHour='$Salon_Open_Time', CloseHour='$Salon_Close_Time', service='$Salon_Type', Logo='$file_location' WHERE SID='$SID' ";
        else 
          $SQL_upp = "UPDATE `salonslist` SET Name='$Salon_Name', Description='$Salon_Description', Location='$Salon_Location', PhoneNubmer='$Salon_Phone_Number', workingDays='$Salon_Time', OpenHour='$Salon_Open_Time', CloseHour='$Salon_Close_Time', service='$Salon_Type' WHERE SID='$SID' ";

        $UPDATE_S = mysqli_query($connection, $SQL_upp);
        $SUCCESS_MSG[] = "Salon Has Been UPDATED Successfully";
        echo '<script>alert("Salon Updated Successfully")</script>';
        echo '<script> window.location.href="SalonProfile.php?SID=' . $SID . '"</script>';
    } else {
        
        if ($canupload == false)
              echo '<script>alert("only image extention are allowed(PNG, JPEG, jpg) ")</script>';
        else 
            echo '<script>alert("Error Please Fill All Details ")</script>';
            
        
        echo '<script> window.location.href="SalonProfile.php?SID=' . $SID . '"</script>';
        echo mysqli_error($UPDATE_S);
    }
}

?>
