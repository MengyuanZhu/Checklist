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
              function score($row, $timepoints)
      				{

                $nthweek=(int)((date("d")-date('d', strtotime(date("m Y")." first monday")))/7)+1;

                //if the first monday is the first date of this month
                if (date('d', strtotime(date("m Y")." first monday"))=="01"){
                  $nthweek=(int)((date('d', strtotime("last monday of last month"))-date('d', strtotime("first monday of last month")))/7)+2;
                }

      					$today=date("N");

      					$attendance = 0;
      				  for ($i = 1; $i < $nthweek; $i++) {
      				    $attendance = $attendance + $row["week" . $i] / 10;
      				  }
      				  if ($today==7){
                  $today=6;//sunday output the same as Saturday
                }
      				  for ($i=0;$i<($today-1)*2;$i++) {
      				    	if ($row[$timepoints[$i]] != NULL) $attendance++;
      				  }

                if ($nthweek==1 && $today==1){
                    return "New month";
                }

                //Labor day
      					$LD = (date('md')-date('md', strtotime("first monday of september")))==(date('N')-1);
                //MLK day
                $MLK = (date('md')-date('md', strtotime("third monday of january")))==(date('N')-1);
                //Memorial day
                $MD = (date('md')-date('md', strtotime("last monday of may")))==(date('N')-1);
                //July 4th
                $JF = date('md')-date('md', strtotime("july 4"));
                $JF = ($JF>0 && $JF< 7-date('N', strtotime("july 4")));


                if ($LD || $MLK || $MD || $JF){
                  if (date('N')==1){
                    $attendance = $attendance / (($nthweek - 1) * 10)*100;
                  }
                  else{
                    $attendance = $attendance / (($nthweek - 1) * 10 + ($today-2)*2)*100;
                  }
                }
                else{
                  $attendance = $attendance / (($nthweek - 1) * 10 + ($today-1)*2)*100;
                }

      				  $score = "E";
      				  if ($attendance > 20) $score = "D";
      				  if ($attendance > 40) $score = "C";
      				  if ($attendance > 60) $score = "B";
      				  if ($attendance > 80) $score = "A";
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
