
<?php

  $comments=$_POST["comments"];
  $author=$_POST["author"];
  $comments=$comments."    By ".$author;
  require ("sql.php");
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $now=date("Y-m-d H:i:s");
  $sql = "INSERT INTO comments (comments_data, datetime) value (\"".$comments. "\",\"" . $now."\")";
  $result = $conn->query($sql);
  echo "Record updated.";
  echo "<br /> Go to <a href=http://checklist.gsu.edu/index.php>homepage</a>";

?>
