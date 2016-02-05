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
        <table style="width:85%;">
        	<tr>
       			<td colspan=2>
		        	<form id="checklist" method="post" action="check_update.php">
			            <table style="width:100%;">
			                <tr>
			                    <td colspan=17 class=blue>
			                        <span id="title"></span>
			                    </td>
			                </tr>
			                <tr>
			                    <th rowspan=2>Name</th>
			                    <th rowspan=2><p style="font-size:10px">Accumulated<br /> attandance</p></th>
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
			                function score($row, $timepoints) {                    
			                    $nthweek = date("W") - date("W", strtotime(date("Y-m-01", time()))) ;;
			                    //echo $nthweek;
			                    $today=date("N");                    
			                    $attandance = 0;

			                    if ($nthweek==0)
			                        $nthweek=5; //need to know how many weeks last month

			                    for ($i = 1; $i < $nthweek; $i++) {
			                        $attandance = $attandance + $row["week" . $i] / 10;
			                    }                    
			                    
			                    if ($today==7)
			                    	$today=6;

			                    for ($i=0;$i<($today-1)*2;$i++) {
			                    	if ($row[$timepoints[$i]] != NULL) $attandance++;
			                    }
			                    $attandance = $attandance / (($nthweek - 1) * 10 + ($today-1)*2)*100;
			                    
			                    if ($attandance <=20) $score = "E";
			                    if ($attandance > 20 && $attandance <= 40) $score = "D";
			                    if ($attandance > 40 && $attandance <= 60) $score = "C";
			                    if ($attandance > 60 && $attandance <= 80) $score = "B";
			                    if ($attandance > 80) $score = "A";                    
			                    $output = number_format($attandance) . "/" . $score;                    
			                    return $output;
			                }
			                if ($result->num_rows > 0) {
			                    while ($row = $result->fetch_assoc()) {
			                        $personname = $row["name"];
			                        $personname = str_replace(' ', '_', $personname);
			                        $output = score($row, $timepoints);
			                        echo "<tr><td class='peoplename'>" . $row["name"] . "</td> <td>" . $output . "</td><td><input type=checkbox name=\"mid_" . $row["name"] . "\"  onClick='submit_on_check()'/></td>";
			    	                	
					                	for($i=0;$i<($today-1)*2;$i++)
					                		echo "<td>".$row[$timepoints[$i]]."</td>";	                   
					                    
					                    if ($row[$timepoints[($today-1)*2]] != NULL) {
					                        echo "<td>" . $row[$timepoints[($today-1)*2]] . "</td>";
					                    }
					                    else {
					                        echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check(this.name)' />In</td>";
					                    }
					                    
					                    if ($row[$timepoints[($today-1)*2+1]] != NULL or ($row[$timepoints[($today-1)*2+1]] == NULL and $row[$timepoints[($today-1)*2]] == NULL)) {
					                        echo "<td>" . $row[$timepoints[($today-1)*2+1]] . "</td>";
					                    }
					                    else {
					                        echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check(this.name)' />Out</td>";
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
				</td>
			</tr>
			<tr>
				<td id="td_comments" style="width:70%;">
					<table style="width:100%; height:100%;" >
					<tr>
					<th >Notes</th>
					<th style="width:180px;">Date Time</th>
					</tr>
					<?php
					$sql = "SELECT * FROM comments order by datetime desc limit 5";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while ($row = $result->fetch_assoc()) {
					        echo "<tr><td style='text-align:left;'>" . $row["comments_data"] . "</td><td>" . $row["datetime"] . "</td></tr>";
					    }
					}		
					?>
					</table>
				</td>
				<td style="background:#FFF">
					<form method="post" action="submit_comments.php">
						<textarea name="comments"  cols="50" id="commentsarea" placeholder="Notes"></textarea><br />
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
						</select><br />
						<input type=checkbox name="wang" value="wang" />Cc to Dr. Wang<br />
						<input type=checkbox name="everybody" value="everybody" />Cc to everybody<br />
					    <input type=submit value="Submit notes">
					</form>
				</td>
			</tr>
		</table>
		<hr />
		<div style="margin:0 auto;width:50%;"> 
			<form method=post action="user.php">
				Add or remove a user:
				<input type=text name="newuser" placeholder="Name" />			
				<input type=text name="email" placeholder="E-mail" />			
				<input type=radio name="user" value="Add" checked=checked /> Add			
				<input type=radio name="user" value="Remove" /> Remove			
				<input type=submit value="User update" />	
			</form>
		</div>

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script>
		    var month = new Array();
		    month[0] = "January";
		    month[1] = "February";
		    month[2] = "March";
		    month[3] = "April";
		    month[4] = "May";
		    month[5] = "June";
		    month[6] = "July";
		    month[7] = "August";
		    month[8] = "September";
		    month[9] = "October";
		    month[10] = "November";
		    month[11] = "December";
		    var weekday = new Array(7);
		    weekday[0] = "Sunday";
		    weekday[1] = "Monday";
		    weekday[2] = "Tuesday";
		    weekday[3] = "Wednesday";
		    weekday[4] = "Thursday";
		    weekday[5] = "Friday";
		    weekday[6] = "Saturday";
		    var d = new Date();
		    var n = month[d.getMonth()];
		    var currenttime = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
		    document.getElementById("title").innerHTML = n + " " + d.getFullYear() + " " + weekday[d.getDay()] + " " + currenttime;
		    function submit_on_check(namestate) {   
				$.post("check_update2.php", $('form#checklist').serialize(),function(response){
					 $('[name='+namestate+']').parent().html(response);	
				});
		    }
		    document.getElementById("commentsarea").rows=6;
		</script>
	</body>
</html>