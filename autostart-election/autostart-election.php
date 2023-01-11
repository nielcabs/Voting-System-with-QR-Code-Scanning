<?php 





    $url        = "../";

  

    include_once($url.'connection/mysql_connect.php');

  

    $date_today = date('m/d/Y');
    $current_time = date('h:i A'); 


    //USC

    $sql_usc    = "SELECT election_id, election_name, status, date_started, date_end, date_start_time

                   FROM dhvsuevo_voting.tbl_election

                   WHERE election_name = 'USC' AND status ='N'";

    $res_usc    = mysqli_query($db, $sql_usc);

    $row_usc    = mysqli_fetch_assoc($res_usc);

    $count_row  = mysqli_num_rows($res_usc);



    $date_started_usc   = $row_usc['date_started'] ?? '';

    $date_end_usc       = $row_usc['date_end'] ?? '';

    $election_id_usc    = $row_usc['election_id'] ?? '';

    $date_start_time_usc    = $row_usc['date_start_time'] ?? '';

    $sql1       = "SELECT * FROM tbl_candidates
                   WHERE election_id='$election_id_usc' 
                   GROUP BY position";
    $qry1       = mysqli_query($db, $sql1);
    $cnt_candidate_usc = mysqli_num_rows($qry1) ?? '';
    //$cnt_candidate_usc = "10";



    if($date_today == $date_started_usc && $current_time == $date_start_time_usc  && $cnt_candidate_usc == 10){



        //USC

        $upt1 = "UPDATE dhvsuevo_voting.tbl_election 

                 SET status = 'In-Progress'

                 WHERE election_name = 'USC' AND status ='N'";

        $result11 = mysqli_query($db,$upt1);



        $upta = "UPDATE dhvsuevo_voting.tbl_candidates 

                     SET election_status = 'In-Progress'

                     WHERE election_id = '$election_id_usc'";

        $resulta = mysqli_query($db,$upta);

        
        $upt1 = "UPDATE tbl_party 
                 SET election_status = 'In-Progress'
                 WHERE election_id = '$election_id_usc'";
        $result1 = mysqli_query($db,$upt1);

        $subject        = "University Student Council Election has been started";
        $election_name  = "USC";
        include_once('email_start_election.php');

    } 





    //FCE

    $sql_fce    = "SELECT election_id, election_name, status, date_started, date_end, date_start_time

                   FROM dhvsuevo_voting.tbl_election

                   WHERE election_name = 'FCE' AND status ='N'";

    $res_fce    = mysqli_query($db, $sql_fce);

    $row_fce    = mysqli_fetch_assoc($res_fce);

    $count_row  = mysqli_num_rows($res_fce);



    $date_started_fce   = $row_fce['date_started'] ?? '';

    $date_end_fce       = $row_fce['date_end'] ?? '';

    $election_id_fce    = $row_fce['election_id'] ?? '';

    $date_start_time_fce    = $row_fce['date_start_time'] ?? '';

    $sql2       = "SELECT * FROM tbl_candidates
                   WHERE election_id='$election_id_fce' 
                   GROUP BY position";
    $qry2       = mysqli_query($db, $sql2);
    $cnt_candidate_fce = mysqli_num_rows($qry2) ?? '';




    if($date_today == $date_started_fce  && $current_time == $date_start_time_fce && $cnt_candidate_fce == 8){



        //FCE

        $upt2 = "UPDATE dhvsuevo_voting.tbl_election 

                 SET status = 'In-Progress'

                 WHERE election_name = 'FCE' AND status ='N'";

        $result12 = mysqli_query($db,$upt2);



        $uptb = "UPDATE dhvsuevo_voting.tbl_candidates 

                SET election_status = 'In-Progress'

                WHERE election_id = '$election_id_fce'";

        $resultb = mysqli_query($db,$uptb);

        $upt2 = "UPDATE tbl_party 
                 SET election_status = 'In-Progress'
                 WHERE election_id = '$election_id_fce'";
        $result2 = mysqli_query($db,$upt2);


        
        $subject        = "Faculty Election has been started";
        $election_name  = "FCE";
        include_once('email_start_election.php');


    } 







    $sql_dept   = "SELECT dept_id, department FROM dhvsuevo_voting.tbl_department";

    $res_dept   =  mysqli_query($db, $sql_dept);



    while($row_dept    = mysqli_fetch_assoc($res_dept)){



        $dept_id   = $row_dept['dept_id'] ?? '';





        //LDSC

        $sql_ldsc    = "SELECT election_id, election_name, status, date_started, date_end, date_start_time

                        FROM dhvsuevo_voting.tbl_election

                        WHERE election_name = 'LDSC' AND status ='N' AND department ='$dept_id'";

        $res_ldsc    = mysqli_query($db, $sql_ldsc);

        $row_ldsc    = mysqli_fetch_assoc($res_ldsc);

        $count_row  = mysqli_num_rows($res_ldsc);



        $date_started_ldsc   = $row_ldsc['date_started'] ?? '';

        $date_end_ldsc       = $row_ldsc['date_end'] ?? '';

        $election_id_ldsc    = $row_ldsc['election_id'] ?? '';

        $date_start_time_ldsc    = $row_ldsc['date_start_time'] ?? '';


        $sql3       = "SELECT * FROM tbl_candidates
                       WHERE election_id='$election_id_fce' 
                       GROUP BY position";
        $qry3       = mysqli_query($db, $sql3);
        $cnt_candidate_ldsc = mysqli_num_rows($qry3) ?? '';


        

        if($date_today == $date_started_ldsc  && $current_time == $date_start_time_ldsc && $cnt_candidate_ldsc ==10){



            $upt1 = "UPDATE dhvsuevo_voting.tbl_election 

                     SET status = 'In-Progress'

                     WHERE election_name = 'LDSC' AND status ='N' AND department ='$dept_id'";

            $result11 = mysqli_query($db,$upt1);



            $upta = "UPDATE dhvsuevo_voting.tbl_candidates 

                     SET election_status = 'In-Progress'

                     WHERE election_id = '$election_id_ldsc'";

            $resulta = mysqli_query($db,$upta);

            $upt3 = "UPDATE tbl_party 
                        SET election_status = 'In-Progress'
                        WHERE election_id = '$election_id_ldsc'";
            $result3 = mysqli_query($db,$upt3);


            $subject        = strtoupper($dept_id)." Localized Student Council Election has been started";
            $election_name  = "LDSC";
            include_once('email_start_election.php');


        } 





    }

	mysqli_close($db); 		

?>