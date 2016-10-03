<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
        Checklist in Dr. Wang's lab
        </title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="checklist.css">
        <link rel="shortcut icon" href="favicon.ico" />
        <style type="text/css">
        a:link {
        	color:black;
        }
        </style>

    </head>
    <body>
	    <div>
	        <table style="width:85%;margin:auto;">
	        	<tr>
	       			<td colspan=2>
			        	<form id="checklist" method="post" action="check_update.php">
				            <table style="width:100%;">
				                <tr>
				                    <td colspan=15 class=blue>
				                        <span id="title"></span>
				                    </td>
				                </tr>
				                <tr>
				                    <th rowspan=2>Name</th>
				                    <th colspan=2>Monday</th>
				                    <th colspan=2>Tuesday</th>
				                    <th colspan=2>Wednesday</th>
				                    <th colspan=2>Thusday</th>
				                    <th colspan=2>Friday</th>
				                    <th colspan=2>Saturday</th>
				                    <th colspan=2>Sunday</th>
				                </tr>
				                <tr>
				                    <?php
				                    for ($i = 0; $i < 7; $i++) echo "<th>Time In</th><th>Time Out</th>";
				                    ?>
				                </tr>
				                <?php
				                $today = date("N");
				                $timepoints=array("mon_in","mon_out","tue_in","tue_out","wed_in","wed_out","thu_in","thu_out","fri_in","fri_out","sat_in","sat_out","sun_in","sun_out");
				                ini_set('display_errors', 'on');
				                Error_reporting(E_ALL);
				                require ("sql.php");
				                $date_raw=date('Y-m-d');

				                //$date= (date('Y-m-d', strtotime('-1 day', strtotime($date_raw))));
				                echo "2016-09-26 ~ 2016-10-02";
				                $sql = "SELECT * FROM history  where date='2016-10-03' order by name";
				                $result = $conn->query($sql);

				                if ($result->num_rows > 0) {
				                    while ($row = $result->fetch_assoc()) {
				                        $personname = $row["name"];
				                        $personname = str_replace(' ', '_', $personname);

				                        echo "<tr class=namerow><td class='peoplename'>" . $row["name"] . "</td>";
						                	for($i=0;$i<14;$i++)
						                		echo "<td>".$row[$timepoints[$i]]."</td>";

						                echo "</tr>";
								    }
								}
							?>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</div>

   		<div style="margin:0 auto;width:100%;text-align:center">

   			<!--<a href="" style="color:black">Previous</a>
   			<a href="" style="color:black">Next</a>
      -->
   			<br />
   			<br/>
	   		<?php
	   			echo date("Y");
	   		?>
	   		<a href="report.php" style="color:black">Report</a>
	   		<a href="mysql" style="color:black">Admin</a>
	   		<a href="index.php" style="color:black">Home</a>
   		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script>
		    //document.getElementById("title").innerHTML ="History"  ;


		    $(".namerow").hover(
				function () {
				    $(this).css("background","#34495E");
				    $(this).css("color","#FFF");
				},
				function () {
				    $(this).css("background","");
				    $(this).css("color","#000");
				}
			);

		</script>
	</body>
</html>
