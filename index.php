<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
        Checklist in Dr. Wang's lab
        </title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="checklist.css">
    </head>
    <body>
        <form id="checklist" method="post" action="check_update.php">
            <table>
                <tr>
                    <td colspan=17 class=blue>
                        <span id="title"></span>
                    </td>
                </tr>
                <tr>
                    <th rowspan=2>Name</th>
                    <th rowspan=2><p style="font-size:10px">Accumulated<br /> attandance</p></th>
                    <th rowspan=2>Midnight</th>
                    <th colspan=2 id="holiday">Monday</th>
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
                $today = date("D");
                ini_set('display_errors', 'on');
                Error_reporting(E_ALL);
                require ("sql.php");
                $sql = "SELECT * FROM people order by name";
                $result = $conn->query($sql);
                $nthweek = ceil(date('j') / 7);
                //nthweek
                function score($row, $today) {
                    
                    $nthweek = ceil(date('j') / 7);
                    $attandance = 0;
                    for ($i = 1; $i < $nthweek; $i++) {
                        $attandance = $attandance + $row["week" . $i] / 10;
                    }
                    
                    if ($today == "Mon") $attandance = $attandance / (($nthweek - 1) * 10 + 0);
                    if ($today == "Tue") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10+2 )*100;
                    }
                    if ($today == "Wed") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        if ($row["tue_out"] != NULL) $attandance++;
                        if ($row["tue_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10 + 4)*100;
                    }
                    if ($today == "Thu") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        if ($row["tue_out"] != NULL) $attandance++;
                        if ($row["tue_in"] != NULL) $attandance++;
                        if ($row["wed_out"] != NULL) $attandance++;
                        if ($row["wed_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10 + 6)*100;
                    }
                    if ($today == "Fri") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        if ($row["tue_out"] != NULL) $attandance++;
                        if ($row["tue_in"] != NULL) $attandance++;
                        if ($row["wed_out"] != NULL) $attandance++;
                        if ($row["wed_in"] != NULL) $attandance++;
                        if ($row["thu_out"] != NULL) $attandance++;
                        if ($row["thu_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10 + 8)*100;
                    }
                    if ($today == "Sat") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        if ($row["tue_out"] != NULL) $attandance++;
                        if ($row["tue_in"] != NULL) $attandance++;
                        if ($row["wed_out"] != NULL) $attandance++;
                        if ($row["wed_in"] != NULL) $attandance++;
                        if ($row["thu_out"] != NULL) $attandance++;
                        if ($row["thu_in"] != NULL) $attandance++;
                        if ($row["fri_out"] != NULL) $attandance++;
                        if ($row["fri_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10 + 10)*100;
                    }
                    if ($today == "Sun") {
                        if ($row["mon_out"] != NULL) $attandance++;
                        if ($row["mon_in"] != NULL) $attandance++;
                        if ($row["tue_out"] != NULL) $attandance++;
                        if ($row["tue_in"] != NULL) $attandance++;
                        if ($row["wed_out"] != NULL) $attandance++;
                        if ($row["wed_in"] != NULL) $attandance++;
                        if ($row["thu_out"] != NULL) $attandance++;
                        if ($row["thu_in"] != NULL) $attandance++;
                        if ($row["fri_out"] != NULL) $attandance++;
                        if ($row["fri_in"] != NULL) $attandance++;
                        $attandance = $attandance / (($nthweek - 1) * 10 + 10);
                    }
                    
                    if ($attandance < 20) $score = "E";
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
                        $output = score($row, $today);
                        echo "<tr><td class='peoplename'>" . $row["name"] . "</td> <td>" . $output . "</td><td><input type=checkbox name=\"mid_" . $row["name"] . "\"  onClick='submit_on_check()'/></td>";
                        
                        if ($today == "Mon") {
                            if ($row["mon_in"] != NULL) {
                                echo "<td>" . $row["mon_in"] . "</td>";
                            }
                            else {
                                echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
                            }
                            
                            if ($row["mon_out"] != NULL or ($row["mon_out"] == NULL and $row["mon_in"] == NULL)) {
                                echo "<td>" . $row["mon_out"] . "</td>";
                            }
                            else {
                                echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
                            }
                            for ($i = 0; $i < 12; $i++) {
                                echo "<td></td>";
                            }
                        echo "</tr>";
                    }
                    
                    if ($today == "Tue") {
                        
                        echo " <td>" . $row["mon_in"] . "</td>
                            <td>" . $row["mon_out"] . "</td>";
                        if ($row["tue_in"] != NULL) {
                            echo "<td>" . $row["tue_in"] . "</td>";
                        }
                        else {
                            echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
                        }
                        
                        if ($row["tue_out"] != NULL or ($row["tue_out"] == NULL and $row["tue_in"] == NULL)) {
                            echo "<td>" . $row["tue_out"] . "</td>";
                        }
                        else {
                            echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
                        }
                        
                        for ($i = 0; $i < 10; $i++) {
                            echo "<td></td>";
                        }
                    echo "</tr>";
                }
                
                if ($today == "Wed") {
                    echo " <td>" . $row["mon_in"] . "</td>
                        <td>" . $row["mon_out"] . "</td>
                        <td>" . $row["tue_in"] . "</td>
                        <td>" . $row["tue_out"] . "</td>";
                    
                    if ($row["wed_in"] != NULL) {
                        echo "<td>" . $row["wed_in"] . "</td>";
                    }
                    else {
                        echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
                    }
                    
                    if ($row["wed_out"] != NULL or ($row["wed_out"] == NULL and $row["wed_in"] == NULL)) {
                        echo "<td>" . $row["wed_out"] . "</td>";
                    }
                    else {
                        echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
                    }
                    
                    for ($i = 0; $i < 8; $i++) {
                        echo "<td></td>";
                    }
                echo "</tr>";
            }
            
            if ($today == "Thu") {
                
                echo " <td>" . $row["mon_in"] . "</td>
                    <td>" . $row["mon_out"] . "</td>
                    <td>" . $row["tue_in"] . "</td>
                    <td>" . $row["tue_out"] . "</td>
                    <td>" . $row["wed_in"] . "</td>
                    <td>" . $row["wed_out"] . "</td>";
                if ($row["thu_in"] != NULL) {
                    echo "<td>" . $row["thu_in"] . "</td>";
                }
                else {
                    echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
                }
                
                if ($row["thu_out"] != NULL or ($row["thu_out"] == NULL and $row["thu_in"] == NULL)) {
                    echo "<td>" . $row["thu_out"] . "</td>";
                }
                else {
                    echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
                }
                
                for ($i = 0; $i < 6; $i++) {
                    echo "<td></td>";
                }
            echo "</tr>";
        }
        
        if ($today == "Fri") {
            echo "<td>" . $row["mon_in"] . "</td>
                <td>" . $row["mon_out"] . "</td>
                <td>" . $row["tue_in"] . "</td>
                <td>" . $row["tue_out"] . "</td>
                <td>" . $row["wed_in"] . "</td>
                <td>" . $row["wed_out"] . "</td>
                <td>" . $row["thu_in"] . "</td>
                <td>" . $row["thu_out"] . "</td>";
            if ($row["fri_in"] != NULL) {
                echo "<td>" . $row["fri_in"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
            }
            
            if ($row["fri_out"] != NULL or ($row["fri_out"] == NULL and $row["fri_in"] == NULL)) {
                echo "<td>" . $row["fri_out"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
            }
            
            for ($i = 0; $i < 4; $i++) {
                echo "<td></td>";
            }
            echo "</tr>";
        }
        
        if ($today == "Sat") {
            echo " <td>" . $row["mon_in"] . "</td>
                <td>" . $row["mon_out"] . "</td>
                <td>" . $row["tue_in"] . "</td>
                <td>" . $row["tue_out"] . "</td>
                <td>" . $row["wed_in"] . "</td>
                <td>" . $row["wed_out"] . "</td>
                <td>" . $row["thu_in"] . "</td>
                <td>" . $row["thu_out"] . "</td>
                <td>" . $row["fri_in"] . "</td>
                <td>" . $row["fri_out"] . "</td>";
            if ($row["sat_in"] != NULL) {
                echo "<td>" . $row["sat_in"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
            }
            
            if ($row["sat_out"] != NULL or ($row["sat_out"] == NULL and $row["sat_in"] == NULL)) {
                echo "<td>" . $row["sat_out"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
            }
            
            for ($i = 0; $i < 2; $i++) {
                echo "<td></td>";
            }
            echo "</tr>";
        }
        
        if ($today == "Sun") {
            
            echo " <td>" . $row["mon_in"] . "</td>
                <td>" . $row["mon_out"] . "</td>
                <td>" . $row["tue_in"] . "</td>
                <td>" . $row["tue_out"] . "</td>
                <td>" . $row["wed_in"] . "</td>
                <td>" . $row["wed_out"] . "</td>
                <td>" . $row["thu_in"] . "</td>
                <td>" . $row["thu_out"] . "</td>
                <td>" . $row["fri_in"] . "</td>
                <td>" . $row["fri_out"] . "</td>
                <td>" . $row["sat_in"] . "</td>
                <td>" . $row["sat_out"] . "</td>";
            if ($row["sun_in"] != NULL) {
                echo "<td>" . $row["sun_in"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=in_" . $personname . " onClick='submit_on_check()' />In</td>";
            }
            
            if ($row["sun_out"] != NULL or ($row["sun_out"] == NULL and $row["sun_in"] == NULL)) {
                echo "<td>" . $row["sun_out"] . "</td>";
            }
            else {
                echo "<td><input type=checkbox class='checkthem' name=out_" . $personname . " onClick='submit_on_check()' />Out</td>";
            }
            echo " </tr>";
        }
    }
}
?>
</form>
</table>
<table ><tr><td>
<table >
<tr>
<th width=600px>Notes</th>
<th width=180px>Date Time</th>
</tr>
<?php
$sql = "SELECT * FROM comments order by datetime desc limit 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td style='text-align:left;'>" . $row["comments_data"] . "</td><td>" . $row["datetime"] . "</td></tr>";
    }
}
$conn->close();
?>
</table>

</td><td>
<form method="post" action="submit_comments.php">
<table >
<tr><td><textarea name="comments" rows="4" cols="50">Notes</textarea></td></tr>
<tr><td><input type=checkbox name="wang" value="wang" />Cc to Dr. Wang</td></tr>
<tr><td><input type=checkbox name="everybody" value="everybody" />Cc to everybody</td></tr>
<tr><td><input type=submit value="Submit notes"></td></tr>
</table>
</form>
</td></tr></table>


<hr />

<table>
<form method=post action="user.php">
<tr>
<td colspan=4></td>
<td colspan=2>Add or remove a user:</td>
<td colspan=1>
<input type=text name="newuser" value="Name" />
</td>
<td colspan=1>
<input type=text name="email" value="E-mail" />
</td>
<td>
<input type=radio name="user" value="Add" checked=checked/> Add
</td>
<td>
<input type=radio name="user" value="Remove" /> Remove
</td>
<td>
<input type=submit value="User update" />
</td>
</tr>
</form>
</table>
<br /><br />
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
    function submit_on_check() {
    document.getElementById("checklist").submit();
    }
    a=d.getFullYear();
    b=d.getMonth();
    c=d.getDate();
    var date = new Date(a, parseInt(b) - 1, c), w = date.getDay(), d = date.getDate();
    var nthweek= Math.ceil( (d + 6 - w) / 7 );
    if (nthweek==3 && b==0)
    {
    document.getElementById("holiday").innerHTML="MLK Day";
    document.getElementById("holiday").style.color="#ff8000";
    }
</script>
</body>
</html>