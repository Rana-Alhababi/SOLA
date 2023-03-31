<?php

include "ConnectDB.php";
$_SESSION['SID'] = $_POST['SID'];
$SID = $_SESSION['SID'];

$title = $_POST['title'];
$rating = $_POST['rating'];

echo "title " . $title . "<br>";

// Check entry within table, if no previous rates will set count to zero, then direct to Insert SQL 
// else if there is previous rates, the count>0, direct to Update SQL


$query = "SELECT count FROM `Rating` WHERE title='$title' and SID='$SID'";
echo $query;
$result = mysqli_query($connection, $query);
$fetchdata = mysqli_fetch_array($result);
if ($fetchdata != null)
    $count = $fetchdata['count'];
else
    $count = 0;
//echo $count . "<br>";

if ($count == 0) {
    $insertquery = "INSERT INTO `Rating`(SID,title,rating,PreviousRating,total,count,average) values('$SID','$title','$rating','0','$rating','1','$rating')";
    echo $insertquery;
    mysqli_query($connection, $insertquery);
} else {
    // find the total of all previous rates
    $query = "SELECT total FROM `Rating` WHERE title='$title' and SID='$SID'";
    $result = mysqli_query($connection, $query);
    $fetch = mysqli_fetch_assoc($result);
    $total = $fetch['total'];
    
    $query = "SELECT rating FROM `Rating` WHERE title='$title' and SID='$SID'";
    $result = mysqli_query($connection, $query);
    $fetch = mysqli_fetch_assoc($result);
    $Prev = $fetch['rating'];

    // increment count and update the total by the current rating, then calculate Average nad round it
    $count++;
    $total += $rating;
    $avg = $total / $count;
    $avg = round($avg);

    $updatequery = "UPDATE `Rating` SET rating='$rating', PreviousRating='$Prev', count='$count',total='$total', count='$count',average='$avg' WHERE title='$title' and SID='$SID'";
    $result= mysqli_query($connection, $updatequery);
  
    echo $updatequery;
}

//Select the updated average either by Update Or Insert SQL, and echo the result back to AJAX request 
$query = "SELECT average as averageRating FROM `Rating` WHERE title='$title' and SID='$SID'";
$result = mysqli_query($connection, $query) or die(mysqli_error());

$fetchAverage = mysqli_fetch_assoc($result);
$averageRating = $fetchAverage['averageRating'];

$return_arr = array("averageRating" => $averageRating);


echo json_encode($return_arr);
?>