

<?php


$comments=$_POST["comments"];
require ("sql.php");
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $now=date("Y-m-d H:i:s");

	if (!empty($_POST["wang"]))
	{

	$wangcomments=$comments."\n"."Please visit this link to know details: 131.96.67.176/comments.php ";
	//mail("wang@gsu.edu", "Checklist", $wangcomments, "From: Wang lab");
	}

	if (!empty($_POST["zhu"]))
	{
    //mail("4044345961@txt.att.net", "Checklist", $comments, "From: Wang lab");

    }

	if (!empty($_POST["everybody"]))
	{

	$sql="select email from people";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
	//mail($row["email"], "Checklist", $comments, "From: Wang lab");

	}





    }
	$sql = "INSERT INTO comments (comments_data, datetime) value (\"".$comments. "\",\"" . $now."\")";


    $result = $conn->query($sql);





 echo "Record updated.";
echo "<br /> Go to <a href=http://checklist.gsu.edu/index.php>homepage</a>";

?>
