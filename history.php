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
				                $sql = "SELECT * FROM history order by name";
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
		    document.getElementById("title").innerHTML ="History"  ;
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
		    $(document).ready(function(){
		    	console.log($("#commentsBlock").height());
		    	$("#commentsarea").rows=5;	

		    });
		   
		    
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
