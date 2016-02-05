<?php

$today        = strtolower(date("D"));
$today_number = date("N");
ini_set('display_errors', 'on');
Error_reporting(E_ALL);
require "sql.php";

foreach ($_POST as $key => $value) {
    $phptime    = date('H:i:s', time());
    $personname = substr($key, strpos($key, "_") + 1, strlen($key));
    $midnight   = substr($key, 0, strpos($key, "_"));
    $personname = str_replace('_', ' ', $personname);

    if ($midnight == "mid") {
        $today_number -= 2;
        $dowMap = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
        $sql    = "UPDATE people SET " . $dowMap[$today_number] . "_out" . "=\"$phptime\" WHERE name='$personname';";
        $result = $conn->query($sql);
        echo $phptime;
    } 

    else {

        $state  = substr($key, 0, strpos($key, "_"));
        $sql    = "SELECT * from people WHERE name='$personname';";
        $result = $conn->query($sql);
        $row    = $result->fetch_assoc();        
        
        if ($row[$today . "_" . $state] == null) {
            $sql = "UPDATE people SET " . $today . "_" . $state . "=\"$phptime\" WHERE name='$personname';";

            if (($state == "out") && ($row[$today . "_in"] != null)) {  //fixed bug. some users did not close browser and checkout. the next day the can checkout before checkin.
                $sql    = "select " . $today . "_in" . " from people WHERE name='$personname';";
                $result = $conn->query($sql);
                $row    = $result->fetch_assoc();
                $span= (strtotime($phptime) - strtotime($row[$today . "_in"]))/60;

                if ($span <5) {
                    echo "<h1>You even did not stay in the lab for 5 minutes...</h1>";
                    
                    echo "<img src='shame-on-you.jpg' alt='shameonyou'>";                   
                } else {
                    $sql    = "UPDATE people SET " . $today . "_" . $state . "=\"$phptime\" WHERE name='$personname';";
                    $result = $conn->query($sql); 
                    echo $phptime;
                }

            } 
            else {      //when it is for in
                $result = $conn->query($sql);
                echo $phptime;
            }
        }
    }
}
