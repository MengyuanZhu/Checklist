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



update people set mon_in=null;
update people set tue_in=null;
update people set wed_in=null;
update people set thu_in=null;
update people set fri_in=null;
update people set sat_in=null;
update people set sun_in=null;
update people set mon_out=null;
update people set tue_out=null;
update people set wed_out=null;
update people set thu_out=null;
update people set fri_out=null;
update people set sat_out=null;
update people set sun_out=null;
update people set sat_in="00:00:00" where name="Ke Wang";
update people set sat_out="00:00:00" where name="Ke Wang";
update people set sun_in="00:00:00" where name="Ke Wang";
update people set sun_out="00:00:00" where name="Ke Wang";
update people set fri_in="00:00:00" where name="Ke Wang";
update people set fri_out="00:00:00" where name="Ke Wang";
update people set thu_in="00:00:00" where name="Ke Wang";
update people set thu_out="00:00:00" where name="Ke Wang";
update people set tue_in="00:00:00" where name="Ke Wang";
update people set tue_out="00:00:00" where name="Ke Wang";
update people set wed_in="00:00:00" where name="Ke Wang";
update people set wed_out="00:00:00" where name="Ke Wang";
update people set mon_in="00:00:00" where name="Ke Wang";
update people set mon_out="00:00:00" where name="Ke Wang";

if ($wk_day == 1) echo ("first week");




?>