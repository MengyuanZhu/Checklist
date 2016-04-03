<?php
$comments = "test";
require ("sql.php");

$wk_day = date("W") - date("W", strtotime(date("Y-m-01", time())))-1 ; //nthweek

ini_set('display_errors', 'on');
Error_reporting(E_ALL);


$sql = "SELECT * FROM people order by name";
$result = $conn->query($sql);
$timepoints=array("mon_in","mon_out","tue_in","tue_out","wed_in","wed_out","thu_in","thu_out","fri_in","fri_out");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $personname = $row["name"]; 

        //attandance
        $attandance = 0;
        foreach($timepoints as $timepoint){
            if ($row[$timepoint] != NULL) $attandance++;
        }
        $attandance = $attandance / 10 * 100;       
        $sql = "UPDATE people SET " . "week".$wk_day . "=\"$attandance\" WHERE name='$personname';";
        //echo $wk_day;
        echo $sql."<br>"; 
        //end of attandance

        $conn->query($sql);

    }
}


foreach ( $timepoints as $timepoint){
    $sql="update people set ".$timepoint."=null;";
    $conn->query($sql);
    echo $sql."<br />";
}

$weekends=array("sat_in","sat_out","sun_in","sun_out");
 foreach ( $weekends as $timepoint){
    $sql="update people set ".$timepoint."=null;";
   $conn->query($sql);
    echo $sql."<br />";
}

if ($wk_day == 0) 

$weekends=array("week1","week2","week3","week4");
 foreach ( $weekends as $timepoint){
    $sql="update people set ".$timepoint."=null;";
    $conn->query($sql);
    echo $sql."<br />";
}


?>