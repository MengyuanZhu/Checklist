<!DOCTYPE html>
<html lang="en">
<head>
	<title>
		Checklist in Dr. Wang's lab
	</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="checklist.css">
	<link rel="shortcut icon" href="favicon.ico" />

</head>
<body> 
	<div class="main">
		<form id="checklist" method="post" action="check_update.php">
			<table>
				<tr>
					<td colspan=17>
						<span id="title"></span>
					</td>
				</tr>
				<tr>
					<th rowspan=2>Name</th>
					<th rowspan=2>Score</th>
					<th rowspan=2>Midnight</th>
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
				$sql = "SELECT * FROM people order by name";
				$result = $conn->query($sql);

				//To calculate attendance
				function score($row, $timepoints) {
					$nthweek = date("W") - date("W", strtotime(date("Y-m-00", time())));				                    

					$today=date("N");
					$attendance = 0;

					if ($nthweek==4)
				        $nthweek=1; //need to know how many weeks last month

				    for ($i = 1; $i < $nthweek; $i++) {
				    	$attendance = $attendance + $row["week" . $i] / 10;
				    }

				    if ($today==7)
				    	$today=6;//sunday output the same as Saturday

				    for ($i=0;$i<($today-1)*2;$i++) {
				    	if ($row[$timepoints[$i]] != NULL) $attendance++;
				    }

				    if ($nthweek<=1 && $today==1){
				    	return "New month";
				    }

				    $attendance = $attendance / (($nthweek - 1) * 10 + ($today-1)*2)*100;

				    if ($attendance <=20) $score = "E";
				    if ($attendance > 20 && $attendance <= 40) $score = "D";
				    if ($attendance > 40 && $attendance <= 60) $score = "C";
				    if ($attendance > 60 && $attendance <= 80) $score = "B";
				    if ($attendance > 80) $score = "A";
				    $output = number_format($attendance) . "/" . $score;

				    return $output;
				}


				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$personname = $row["name"];
						$personname = str_replace(' ', '_', $personname);
						$output = score($row, $timepoints);
						echo "<tr class=namerow><td class='peopleName'>" . $row["name"] . "</td> <td>" . $output . "</td><td><input type=checkbox id=mid_$personname name=\"mid_" . $row["name"] . "\"  onClick='submit_on_check(this.name)'/></td>";
						for($i=0;$i<($today-1)*2;$i++)
							echo "<td>".$row[$timepoints[$i]]."</td>";

						if ($row[$timepoints[($today-1)*2]] != NULL) {
							echo "<td>" . $row[$timepoints[($today-1)*2]] . "</td>";
						}
						else {
							echo "<td class='itemin'><input type=checkbox name=in_$personname id=in_$personname onClick='submit_on_check(this.name)' /><label for=in_$personname>In</label></td>";
						}

						if ($row[$timepoints[($today-1)*2+1]] != NULL or ($row[$timepoints[($today-1)*2+1]] == NULL and $row[$timepoints[($today-1)*2]] == NULL)) {
							echo "<td>" . $row[$timepoints[($today-1)*2+1]] . "</td>";
						}
						else {
							echo "<td class='itemout'><input type=checkbox class='checkthem' name=out_$personname id=out_$personname onClick='submit_on_check(this.name)' /><label for=out_$personname>Out</label></td>";
						}

						for ($i = 0; $i < (7-$today)*2; $i++) {
							echo "<td></td>";
						}
						echo "</tr>";
					}
				}
				?>
			</table>
		</form>
	</div>
	<div class="main-comments">
		<div class="column-left">
			<table>
				<tr>
					<th >Notes (<a href="comments.php" >more...</a>)</th>
					<th class="cell-datetime">Date Time</th>
				</tr>
				<?php
				$sql = "SELECT * FROM comments order by datetime desc limit 5";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr><td class='cell-comments'>" . $row["comments_data"] . "</td><td>" . $row["datetime"] . "</td></tr>";
					}
				}
				?>
			</table>
		</div>
		<div class="column-right">
			<form method="post" action="submit_comments.php" >
				<textarea name="comments"  rows="8" cols="50" id="commentsarea" placeholder="Notes" ></textarea><br />
				Signature:
				<select name="author">
					<?php
					$sql = "SELECT * FROM people order by name";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "<option>".$row["name"]."</option>";
						}
					}
					$conn->close();
					?>
				</select> 						
				<input type=submit value="Submit">
			</form>
		</div>
	</div>
	<div class="footer">
		<br/>
		<?php
		echo date("Y"); 
		?>  
		<a href="report.php" class="link-black">Report</a>
		<a href="mysql" class="link-black">Admin</a>
		<a href="history.php" class="link-black">History</a>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>		
	<script src="checklist.js"></script>
</body>
</html>
