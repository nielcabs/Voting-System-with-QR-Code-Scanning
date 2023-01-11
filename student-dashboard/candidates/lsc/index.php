<?php
    if (!isset($_SESSION)) {
        session_start(); 
    }

    $url        = "../../../";
    $urlpic     = "../../../";
    $addBack 	= '../home/';
    include_once($url.'connection/mysql_connect.php');
    $username_id        = $_SESSION['username_id'];
    $access_rights      = $_SESSION['access_rights'];
    $fullname           = $_SESSION['fullname'];
    $department         = $_SESSION['dept_id'];
    $chg_password       = $_SESSION['chg_password'];
    $first_name         = $_SESSION['first_name'];
    $middle_name        = $_SESSION['middle_name'] ;
    $last_name          = $_SESSION['last_name'];
    $dept_id            = $_SESSION['dept_id'] ;
    $email              = $_SESSION['email'];

    $election_id_usc    = $_SESSION['election_id_usc'] ;
    $status_elec_usc    = $_SESSION['status_elec_usc'];
    $election_id_dept   = $_SESSION['election_id_dept'] ;
    $status_elec_dept   = $_SESSION['status_elec_dept'];

    $sql        = "SELECT * FROM tbl_department WHERE dept_id='$dept_id'";
    $res        = mysqli_query($db, $sql);
    $row        = mysqli_fetch_assoc($res);
    $dept_name  = $row['department'];


    $sql2   ="SELECT a.election_id, a.election_name, a.status, a.date_started, a.date_end, b.description, a.department
                FROM tbl_election a
                LEFT JOIN tbl_election_type b
                ON b.election_type=a.election_name
                WHERE a.status = '$status_elec_dept' AND a.election_name='LDSC' AND a.department ='$dept_id'
                AND a.election_id='$election_id_dept'";
    $res2 = mysqli_query($db,$sql2);
    $row2 = mysqli_fetch_assoc($res2);
    
    $id_election2        = $row2['election_id'] ?? '';
    $status              = $row2['status'] ?? '';
    include_once($url.'connection/session.php');

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
</head>

<body class="sb-nav-fixed">
    <div id="myloader" style="display:none;"></div>
    <div id="layoutSidenav">
        <?php include_once($url."sidebar.php"); ?>
        <div id="layoutSidenav_content">
            <main class="mt-5"> 
                <div class="container">  
                    <h4 class="mb-4 mt-4 dashboard-text">Candidates as of  <?php echo $monthName . ' ' . $day. ', '. $year; ?></h4>
                    <section class="content-wrapper h-100">
                        <h5 class="candidates-header fw-bold bg-red text-white text-center p-2 mb-0">Localized Student Council</h5>
                        <?php if($status =='In-Progress'){ ?>
                            <div id="carouselCandidatesSC" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-3">
                                <?php
                                    $sql = "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.position, a.platform, a.party_name, a.election_id, a.dept_id, a.year, b.position_name, a.profile_pic
                                            FROM tbl_candidates a  
                                            LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='LDSC') b
                                            ON b.position_id = a.position
                                            WHERE a.election_id='$id_election2'";
                                    $result = mysqli_query($db, $sql);
                                    while($row    = mysqli_fetch_assoc($result)) {
                                        $rec_id               = $row['rec_id'];
                                        $student_id           = $row['student_id'];
                                        $first_name_v         = $row['first_name'];
                                        $middle_name_v        = $row['middle_name'];
                                        $last_name_v          = $row['last_name'];
                                        $position             = $row['position'];
                                        $platform             = $row['platform'];
                                        $election_id          = $row['election_id'];
                                        $dept_id              = $row['dept_id'];
                                        $year                 = $row['year'];
                                        $post_name            = $row['position_name'];
                                        $party_name           = $row['party_name'];
                                        $profile_pic_v        = $row['profile_pic'];
                                        $candidate_name       = $last_name_v.', '.$first_name_v.' '.$middle_name_v;
                                ?>
                                    <div class="card border-0 mt-3 bg-light-orange">
                                        <div class="row g-0 justify-content-center justify-content-lg-start text-center text-lg-start">
                                            <div class="col-12 col-lg-auto p-3 candidate-page">
                                                <?php if($profile_pic_v !=''){?>
                                                    <img width="150px" height="150px" class="avatar-image rounded-circle" src="<?php echo "../../../".$profile_pic_v; ?>" alt="Image">
                                                <?php } else {?>
                                                    <img class="avatar-image rounded-circle" src="../../../img/speech.png" alt="Image" width="150px" height="150px">
                                                <?php }?>
                                            </div>
                                            <div class="col-12 col-md-9 candidate-page">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $candidate_name; ?></h5>
                                                    <p class="card-text"><small class="text-muted">Position: <?php echo $post_name; ?> | Partylist: <?php echo $party_name; ?></small></p>
                                                    <h5>Platform</h5>
                                                    <p class="card-text platform-text"><?php echo $platform; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="alert alert-warning" role="alert" id="not-selected">
                                <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> No Election In-Progress</h3>
                            </div>
                        <?php } ?>
                    </section>
                </div>
            </main>
            <?php include($url.'footer.php'); ?>  
        </div>
    </div>
</body>
</html>
<?php mysqli_close($db); ?>
