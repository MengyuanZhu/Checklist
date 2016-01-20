<?php
require ("sql.php");

	$sql = "SELECT * FROM comments";
    $result = $conn->query($sql);

?>

 <link rel="stylesheet" type="text/css" href="checklist.css">
<table>
<tr>
<th>Comments
</th>
<th>Date Time
</th>
<?php
if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {

echo "<tr><td>". $row["comments_data"]."</td><td>".$row["datetime"]."</td></tr>";
}
}

?>

</table>
