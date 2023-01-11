<?php 





    $url        = "../";

  

    include_once($url.'connection/mysql_connect.php');

  

    $date_today     = date('m/d/Y');
    $current_time   = date('h:i A'); 


    //USC

    $sql_usc    = "SELECT election_id, election_name, status, date_started, date_end, date_end_time

                   FROM dhvsuevo_voting.tbl_election

                   WHERE election_name = 'USC' AND status ='In-Progress'";

    $res_usc    = mysqli_query($db, $sql_usc);

    $row_usc    = mysqli_fetch_assoc($res_usc);

    $count_row  = mysqli_num_rows($res_usc);



    $date_started_usc   = $row_usc['date_started'] ?? '';

    $date_end_usc       = $row_usc['date_end'] ?? '';

    $election_id_usc    = $row_usc['election_id'] ?? '';

    $date_end_time_usc    = $row_usc['date_end_time'] ?? '';


    // Convert datetime to Unix timestamp
    $timestamp_usc          = strtotime($date_end_time_usc);
    // Subtract time from datetime
    $time_send_notif_usc    = $timestamp_usc - 3600;

    if($date_today == $date_end_usc  && $current_time == $time_send_notif_usc){

        $subject        = "University Student Council Election will end after an hour";
        $election_name  = "USC";
        include_once('email_end_election.php');

    }

    if($date_today == $date_end_usc  && $current_time == $date_end_time_usc){



        //USC

        $upt1 = "UPDATE dhvsuevo_voting.tbl_election 

                SET status = 'Completed'

                WHERE election_name = 'USC' AND status ='In-Progress'";

        $result11 = mysqli_query($db,$upt1);



        $upta = "UPDATE dhvsuevo_voting.tbl_candidates 

                     SET election_status = 'Completed'

                     WHERE election_id = '$election_id_usc'";

        $resulta = mysqli_query($db,$upta);

        $upt1 = "UPDATE tbl_party 
                 SET election_status = 'Completed'
                 WHERE election_id = '$election_id_usc'";
        $result1 = mysqli_query($db,$upt1);



    } 



    //FCE

    $sql_fce    = "SELECT election_id, election_name, status, date_started, date_end, date_end_time

                   FROM dhvsuevo_voting.tbl_election

                   WHERE election_name = 'FCE' AND status ='In-Progress'";

    $res_fce    = mysqli_query($db, $sql_fce);

    $row_fce    = mysqli_fetch_assoc($res_fce);

    $count_row  = mysqli_num_rows($res_fce);



    $date_started_fce   = $row_fce['date_started'] ?? '';

    $date_end_fce       = $row_fce['date_end'] ?? '';

    $election_id_fce    = $row_fce['election_id'] ?? '';

    $date_end_time_fce   = $row_fce['date_end_time'] ?? '';

    // Convert datetime to Unix timestamp
    $timestamp_fce          = strtotime($date_end_time_fce);
    // Subtract time from datetime
    $time_send_notif_fce    = $timestamp_fce - 3600;

    if($date_today == $date_end_usc  && $current_time == $time_send_notif_fce){

        $subject        = "Faculty Election will end after an hour";
        $election_name  = "FCE";
        include_once('email_end_election.php');

    }



    if($date_today == $date_end_fce  && $current_time == $date_end_time_fce){

   

        //FCE

        $upt2 = "UPDATE dhvsuevo_voting.tbl_election 

                SET status = 'Completed'

                WHERE election_name = 'FCE' AND status ='In-Progress'";

        $result12 = mysqli_query($db,$upt2);



        $uptb = "UPDATE dhvsuevo_voting.tbl_candidates 

                SET election_status = 'Completed'

                WHERE election_id = '$election_id_fce'";

        $resultb = mysqli_query($db,$uptb);

        $upt2 = "UPDATE tbl_party 
                 SET election_status = 'Completed'
                 WHERE election_id = '$election_id_fce'";
        $result2 = mysqli_query($db,$upt2);



    } 





    //Local Election

    $sql_dept   = "SELECT dept_id, department FROM dhvsuevo_voting.tbl_department";

    $res_dept   =  mysqli_query($db, $sql_dept);



    while($row_dept    = mysqli_fetch_assoc($res_dept)){



        $dept_id   = $row_dept['dept_id'] ?? '';



        //LDSC

        $sql_ldsc    = "SELECT election_id, election_name, status, date_started, date_end, date_end_time

                    FROM dhvsuevo_voting.tbl_election

                    WHERE election_name = 'LDSC' AND status ='In-Progress' AND department ='$dept_id'";

        $res_ldsc    = mysqli_query($db, $sql_ldsc);

        $row_ldsc    = mysqli_fetch_assoc($res_ldsc);

        $count_row  = mysqli_num_rows($res_ldsc);



        $date_started_ldsc   = $row_ldsc['date_started'] ?? '';

        $date_end_ldsc       = $row_ldsc['date_end'] ?? '';

        $election_id_ldsc    = $row_ldsc['election_id'] ?? '';

        $date_end_time_ldsc   = $row_ldsc['date_end_time'] ?? '';


     
        // Convert datetime to Unix timestamp
        $timestamp_ldsc          = strtotime($date_end_time_ldsc);
        // Subtract time from datetime
        $time_send_notif_ldsc   = $timestamp_ldsc - 3600;

        if($date_today == $date_end_ldsc  && $current_time == $time_send_notif_ldsc){

            $subject        = strtoupper($dept_id)." Localized Student Council Election will end after an hour";
            $election_name  = "LDSC";
            include_once('email_end_election.php');

        }

        if($date_today == $date_end_ldsc  && $current_time == $date_end_time_ldsc) {



            $upt1 = "UPDATE dhvsuevo_voting.tbl_election 

                     SET status = 'Completed'

                     WHERE election_name = 'LDSC' AND status ='In-Progress' AND department ='$dept_id'";

            $result11 = mysqli_query($db,$upt1);



            $upta = "UPDATE dhvsuevo_voting.tbl_candidates 

                     SET election_status = 'Completed'

                     WHERE election_id = '$election_id_ldsc'";

            $resulta = mysqli_query($db,$upta);


            $upt3 = "UPDATE tbl_party 
                        SET election_status = 'Completed'
                        WHERE election_id = '$election_id_ldsc'";
            $result3 = mysqli_query($db,$upt3);




        } 





    }
    

	mysqli_close($db); 		

?>