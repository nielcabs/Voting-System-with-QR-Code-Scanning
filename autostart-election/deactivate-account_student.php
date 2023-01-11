<?php 

    $url        = "../";
    include_once($url.'connection/mysql_connect.php');

  
    $date_today     = date('m/d/Y');
    $cur_year       = date('Y');
    $current_time   = date('h:i A'); 

    $sql_std_voter  = "SELECT username_id, active, DATE_FORMAT(date_added, '%m/%d/%Y') date_added, right(DATE_FORMAT(date_added, '%m/%d/%Y'),4) year_added, dept_id
                       FROM tbl_users
                       WHERE active='Y' AND access_rights='std_voter'";
    $result_std     = mysqli_query($db, $sql_std_voter);
    $row_std        = mysqli_fetch_assoc($result_std);
    while($row_std  = mysqli_fetch_assoc($result_std)){


        $username_id        = $row_std['username_id'];
        $dept_id            = $row_std['dept_id'];
        $year_added         = $row_std['year_added'];

        $year_not_voted     = $cur_year - $year_added;

        $sql_v      = "SELECT student_id_voter, election_id, status_vote
                       FROM tbl_voter_status
                       WHERE student_id_voter ='$username_id'";
        $res_v      = mysqli_query($db, $sql_v);
        $row_v      = mysqli_fetch_assoc($res_v);
        $cnt_v      = mysqli_num_rows($res_v);

    

        if($cnt_v == 0 &&  $year_not_voted =="2"){
            
            $sql_e          = "SELECT date_started, election_id
                               FROM tbl_election
                               WHERE election_name IN ('USC')
                               AND right(date_started,4) >='$year_added'
                               AND right(date_started,4) <='$cur_year'";
            $res_e          = mysqli_query($db, $sql_e );
            $cnt_e          = mysqli_num_rows($res_e);

            $sql_f          = "SELECT date_started, election_id
                               FROM tbl_election
                               WHERE election_name IN ('LDSC') AND department ='$dept_id'
                               AND right(date_started,4) >='$year_added'
                               AND right(date_started,4) <='$cur_year'";
            $res_f          = mysqli_query($db, $sql_f );
            $cnt_f          = mysqli_num_rows($res_f);

            $total_year_not_voting = $cnt_e + $cnt_f;

            if($total_year_not_voting >= 4){

                //Student who did not vote for 2 Consecutive Years
                $username_id    = $row_std['username_id'];

                $upt1 = "UPDATE tbl_users 
                         SET active = 'N'
                         WHERE username_id = '$username_id'";
                $result11 = mysqli_query($db,$upt1);

            }
      

        }
    

    }



?>