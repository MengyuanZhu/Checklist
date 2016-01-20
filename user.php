
<?php
require ("sql.php");

	if ($_POST["user"]=="Add")
{
$sql = "INSERT INTO people (name) VALUES (\"".$_POST["newuser"]."\");";
}

	if ($_POST["user"]=="Remove")
{

$sql = "DELETE FROM people WHERE name = \"".$_POST["newuser"]."\";";

}


if ($conn->query($sql) === TRUE) {
    echo "Record updated.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

echo "<br /> Go to <a href=index.php>homepage</a>";
?>
