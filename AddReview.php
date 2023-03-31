<?php

include 'ConnectDB.php';
session_start();
        $SID = $_POST['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitReview'])) {

    $count = -1;
    if (isset($_POST['addSer'])) {
        foreach ($_POST['addSer'] as $key => $value)
            $count++;
    }
    if ((empty($_POST['rev'])) || $count == -1) {
        echo '<script> alert("error, fill the form correctly")</script> ';
    } else {
        // find max id of reviews
        $maxID = "SELECT MAX(RevID) FROM `Review`";
        $maxID = mysqli_query($connection, $maxID);
        $maxID = mysqli_fetch_assoc($maxID);
        foreach ($maxID as $maxID)
            $maxID++;
        $Description = $_POST['rev'];
        // adding selected services to string then add it as set in DB
        $service = "";
        if ($count == 0)
            $service = $value;

        if ($count > 0) {
            $service = $_POST['addSer'][0];

            for ($index = 1; $index <= $count; $index++) {
                $service = $service . "," . $_POST['addSer'][$index];
            }
        }
        $sql = "INSERT INTO `Review`(`RevID`, `Description`, `service`, `SID`) VALUES ('$maxID','$Description','$service','$SID')";
        $co = mysqli_query($connection, $sql);
        echo '<script>  alert("Your Review added successfully")</script> ';
        echo '<script> location.href="SalonProfile.php?SID=' . $SID . '"</script>';
    }
}

?>



