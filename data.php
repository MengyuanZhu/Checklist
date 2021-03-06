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
			                    <th>Name</th>
			                    <th><p style="font-size:10px">Accumulated<br /> attandance</p></th>
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
			                        $nthweek=4; //need to know how many weeks last month

			                    for ($i = 1; $i < $nthweek; $i++) {
			                        $attandance = $attandance + $row["week" . $i] / 10;
			                    }                    
			                    
			                    if ($today==7)
			                    	$today=6;

			                    for ($i=0;$i<($today-1)*2;$i++) {
			                    	if ($row[$timepoints[$i]] != NULL) $attandance++;
			                    }

			                    if ($nthweek==1 && $today==1){
			                    	return "New month";
			                    } 

			                    $attandance = $attandance / (($nthweek - 1) * 10 + ($today-1)*2)*100;
			                    
			                    if ($attandance <=20) $score = "E";
			                    if ($attandance > 20 && $attandance <= 40) $score = "D";
			                    if ($attandance > 40 && $attandance <= 60) $score = "C";
			                    if ($attandance > 60 && $attandance <= 80) $score = "B";
			                    if ($attandance > 80) $score = "A";                    
			                    $output = $score;
			                                       
			                    return $output;
			                }


			                if ($result->num_rows > 0) {
			                    while ($row = $result->fetch_assoc()) {
			                        $personname = $row["name"];
			                        $personname = str_replace(' ', '_', $personname);
			                        $output = score($row, $timepoints);
			                        echo "<tr class=namerow><td class='peoplename'>" . $row["name"] . "</td> <td>" . $output . "</td>";
					                	
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
					<th >Notes (<a href="comments.php" >more...</a>)</th>
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

		    	var state=namestate.split("_")[0];
		    	var name=namestate.substring(namestate.indexOf("_")+1,namestate.length)
		    	
		    	if (state=="in" || state=="out"){
			    	if (state=="in") {
			    		$('[name='+namestate+']').parent().next().html("<input type=checkbox class=checkthem name=out_"+name+" onclick=submit_on_check(this.name)> Out");
					}
					$.post("check_update.php", $('form#checklist').serialize(),function(response){
						 $('[name='+namestate+']').parent().html(response);	
					});
		    	}
		    	else{//when state is mid
		    		namestate=namestate.split(" ").join("_");
		    		name=name.split(" ").join("_");
		    		//console.log('[name=in_'+name+']')
		    		$.post("check_update.php", $('form#checklist').serialize(),function(response){
						$('[name=in_'+name+']').parent().prev().html(response);	
					});
					var selector="#"+namestate
					$(selector).prop('checked',false);					
		    	}	
		    }
		    document.getElementById("commentsarea").rows=5;
		    $(".namerow").not(':first').hover(
				function () {
				    $(this).css("background","#337AB7");
				}, 
				function () {
				    $(this).css("background","");
				}
			);

		</script>
	</body>
</html>