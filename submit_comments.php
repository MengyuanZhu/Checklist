
<?php
require 'PHPMailer/PHPMailerAutoload.php';



$comments=$_POST["comments"];
$author=$_POST["author"];
$comments=$comments."    By ".$author;

require ("sql.php");
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $now=date("Y-m-d H:i:s");


$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'mzhu7@gsu.edu';                 // SMTP username
$mail->Password = 'Zmy120101#';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('mzhu7@gsu.edu', 'Mailer');
$mail->addAddress('mzhu7@gsu.edu');     // Add a recipient
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Checklist';
$mail->Body    = $comments;

	$sql = "INSERT INTO comments (comments_data, datetime) value (\"".$comments. "\",\"" . $now."\")";


    $result = $conn->query($sql);



	if (!empty($_POST["wang"]))
	{

	$mail->addAddress('wang@gsu.edu'); 
	
	}


	//mail("mzhu7@gsu.edu", "Checklist", $comments, "From: Wang lab");



	if (!empty($_POST["everybody"]))
	{

	$sql="select email from people";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
	$mail->addAddress($row["email"]);	

	}


	if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}





    }






 echo "Record updated.";
 echo "<br /> Go to <a href=http://checklist.gsu.edu/index.php>homepage</a>";

?>
