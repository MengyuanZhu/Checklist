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

			            <table style="width:30%;margin:auto;">
			                <tr>
			                    <th>Name</th>
			                    <th>Accumulated attendance</th>
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
			                    $nthweek = date("W") - date("W", strtotime(date("Y-m-00", time()))) ;;
			                    //echo $nthweek;
			                    $today=date("N");
			                    $attendance = 0;


			                    if ($nthweek==0)
			                        $nthweek=5; //need to know how many weeks last month

			                    for ($i = 1; $i < $nthweek; $i++) {
			                        $attendance = $attendance + $row["week" . $i] / 10;
			                    }

			                    if ($today==7)
			                    	$today=6;

			                    for ($i=0;$i<($today-1)*2;$i++) {
			                    	if ($row[$timepoints[$i]] != NULL) $attendance++;
			                    }

			                    if ($nthweek==1 && $today==1){
			                    	return "New month";
			                    }

								for ($i=0;$i<($today-1)*2;$i++) {
								    if ($row[$timepoints[$i]] != NULL) $attendance++;
								}
							    $attendance = $attendance / (($nthweek - 1) * 10 + ($today-1)*2)*100;

								$LD = date('d', strtotime("september ".date("Y")." first monday"));  //labor day date
								//if holiday, skip the first day
							    if ($nthweek==1 && (date("d")-$LD)==($today-1)){
							    	$attendance=0;
							    	for ($i=2;$i<($today-1)*2;$i++) {
							    		if ($row[$timepoints[$i]] != NULL) $attendance++;
							    	}	
							    $attendance = $attendance / (($nthweek - 1) * 10 + ($today-2)*2)*100;
								}    

			                    if ($attendance <=20) $score = "E";
			                    if ($attendance > 20 && $attendance <= 40) $score = "D";
			                    if ($attendance > 40 && $attendance <= 60) $score = "C";
			                    if ($attendance > 60 && $attendance <= 80) $score = "B";
			                    if ($attendance > 80) $score = "A";
			                    $output = number_format($attendance) ;

			                    return $score;
			                }


			                if ($result->num_rows > 0) {
			                    while ($row = $result->fetch_assoc()) {
			                        $personname = $row["name"];
			                        $personname = str_replace(' ', '_', $personname);
			                        $output = score($row, $timepoints);
			                        echo "<tr class=namerow><td class='peoplename'>" . $row["name"] . "</td> <td>" . $output . "</td></tr>";


							    }
							}
						?>
						</table>



	</body>
</html>
