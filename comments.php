<?php
require ("sql.php");

	$sql = "SELECT * FROM comments order by datetime desc";
    $result = $conn->query($sql);

?>

 <link rel="stylesheet" type="text/css" href="checklist.css">
<table style="width:70%;">
<tr>
<th>Notes
</th>
<th style="width:30%;">Date Time
</th>
<?php
if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {

echo "<tr><td>". $row["comments_data"]."</td><td>".$row["datetime"]."</td></tr>";
}
}

?>

</table>
