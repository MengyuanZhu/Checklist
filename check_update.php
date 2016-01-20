<?php

$today = date("D");
$today_number=date("N");
ini_set('display_errors', 'on');
Error_reporting(E_ALL);
require ("sql.php");

foreach($_POST as $key => $value)
	{

	$phptime = date('H:i:s', time());
	$personname = substr($key, strpos($key, "_") + 1, strlen($key));
  $midnight=substr($key, 0, strpos($key, "_") );
	$personname = str_replace('_', ' ', $personname);


  if ($midnight=="mid"){
    $today_number-=2;
    $dowMap = array( 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');

    $sql = "UPDATE people SET " . $dowMap[$today_number] . "_out" . "=\"$phptime\" WHERE name='$personname';";
    $result = $conn->query($sql);
  }

  else{


	$state = substr($key, 0, strpos($key, "_"));
	$sql = "select " . $today . "_" . $state . " from people WHERE name='$personname';";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if ($row[$today . "_" . $state] == NULL)
		{
		$sql = "UPDATE people SET " . $today . "_" . $state . "=\"$phptime\" WHERE name='$personname';";
		$result = $conn->query($sql);
		}

    }
	}




header("Refresh:0; url=index.php");

?>
