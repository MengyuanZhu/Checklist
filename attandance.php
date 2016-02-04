              <?php
                function score($row, $today) {
                    
                    $nthweek = ceil((date('j')-(6-date('N')))/ 7)-1;
                    //echo $nthweek;
                    $attandance = 0;
                    if ($nthweek==0)
                        $nthweek=5;
                    for ($i = 1; $i < $nthweek; $i++) {
                        $attandance = $attandance + $row["week" . $i] / 10;
                    }
                    
                    if ($today == "Mon") $attandance = $attandance / (($nthweek - 1) * 10 + 0)*100;
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
                        $attandance = $attandance / (($nthweek -1) * 10 + 6)*100;
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

                    if ($today == "Sun" || $today == "Sat") {
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
                        $attandance = $attandance / (($nthweek - 2) * 10 + 10)*100;
                    }
                    
                    if ($attandance <=20) $score = "E";
                    if ($attandance > 20 && $attandance <= 40) $score = "D";
                    if ($attandance > 40 && $attandance <= 60) $score = "C";
                    if ($attandance > 60 && $attandance <= 80) $score = "B";
                    if ($attandance > 80) $score = "A";
                    
                    $output = number_format($attandance) . "/" . $score;
                    
                    return $output;
                }
                ?>