<?php
$comments = "test";
require ("sql.php");

$wk_day = ceil(date('j') / 7); //nthweek

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
        echo $sql."<br>"; 
        //end of attandance

        //$conn->query($sql);

    }
}


foreach ( $timepoints as $timepoint){
    $sql="update people set ".$timepoint."=null;";
    echo $sql."<br />";
}




if ($wk_day == 1) echo ("first week");




?>