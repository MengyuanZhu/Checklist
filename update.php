<?php
$comments = "test";
require ("sql.php");

$wk_day = (int)((date("d")-date('d', strtotime(date("m Y")." first monday")))/7)+1;

//if the first monday is the first date of this month
if (date('d', strtotime(date("m Y")." first monday"))=="01"){
  $wk_day=(int)((date('d', strtotime("last monday of last month"))-date('d', strtotime("first monday of last month")))/7)+2;
}

ini_set('display_errors', 'on');
Error_reporting(E_ALL);


$sql = "SELECT * FROM people order by name";
$result = $conn->query($sql);
$timepoints=array("mon_in","mon_out","tue_in","tue_out","wed_in","wed_out","thu_in","thu_out","fri_in","fri_out");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $personname = $row["name"];
        $attandance = 0;
        for ($i=0;$i<5*2;$i++) {
            if ($row[$timepoints[$i]] != NULL) $attendance++;
        }
        //Labor day
        $LD = (date('md')-date('md', strtotime("first monday of september")))==(date('N')-1);
        //MLK day
        $MLK = (date('md')-date('md', strtotime("third monday of january")))==(date('N')-1);
        //Memorial day
        $MD = (date('md')-date('md', strtotime("last monday of may")))==(date('N')-1);
        //July 4th
        $JF = date('md')-date('md', strtotime("july 4"));
        $JF = ($JF>0 && $JF<= 7-date('N', strtotime("july 4")));


        if ($LD || $MLK || $MD || $JF){
          if (date('N')==1){
            $attendance = $attendance * 10;
          }
          else{
            $attendance = $attendance*10;
          }
        }
        else{
          $attendance = $attendance *10;
        }

        $sql = "UPDATE people SET " . "week".$wk_day . "=\"$attandance\" WHERE name='$personname';";

        echo $sql."<br>";


        $conn->query($sql);

    }
}


foreach ( $timepoints as $timepoint){
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
