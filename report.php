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
			                    <th>Accumulated attandance</th>
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
			                    $output = number_format($attandance) ;

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
