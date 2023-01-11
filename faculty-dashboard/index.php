<?php
     if (!isset($_SESSION)) { 
        session_start(); 
    } 
    
    $url        = "../";
    $urlpic     = "../../";
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

    $election_id_fce    = $_SESSION['election_id_fce'] ;
    $status_elec_fce    = $_SESSION['status_elec_fce'];


    $sql        = "SELECT * FROM tbl_department WHERE dept_id='$dept_id'";
    $res        = mysqli_query($db, $sql);
    $row        = mysqli_fetch_assoc($res);
    $dept_name  = $row['department'];


    $sql1   ="SELECT a.election_id, a.election_name, a.status, a.date_started, a.date_end, b.description, a.department
                FROM tbl_election a
                LEFT JOIN tbl_election_type b
                ON b.election_type=a.election_name
                WHERE a.status = '$status_elec_fce' AND a.election_name='FCE' AND a.election_id ='$election_id_fce'";
    $res1 = mysqli_query($db,$sql1);
    $row1 = mysqli_fetch_assoc($res1);
    
    $id_election1        = $row1['election_id'] ?? '';
    $status              = $row1['status'] ?? '';

    //Check if already voted
    $sql2    ="SELECT a.election_id, a.student_id_voter, a.status_vote
                FROM tbl_voter_status a
                WHERE a.election_id = '$id_election1' and student_id_voter = '$username_id'";
    $res2 = mysqli_query($db,$sql2);
    $row2 = mysqli_fetch_assoc($res2);

    $my_status_vote_fce        = $row2['status_vote'] ?? '';

    include_once($url.'connection/session.php');

    $monthName      = date('F', mktime(0, 0, 0, date('m'), 10));
    $day            = date('d');
    $year           = date('Y');
    $date_from      = date('m/d/Y'); 
?>

<?php 
    //if($change_comp === 'N') {

        // Profile
        $sql	="SELECT profile_pic
                FROM tbl_users
                WHERE username_id ='$username_id'";	
        $res       = mysqli_query($db, $sql) or die (mysqli_error($db));
        $row       = mysqli_fetch_assoc($res);

        $profile_pic           = $row['profile_pic'] ?? '';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $myWebTitles; ?></title>
    <?php include_once($url.'head.php'); ?>
    <style>
        #sidebar-nav {
            width: 445px;
        }
   </style>
</head>

<body class="sb-nav-fixed">
<div id="myloader" style="display:none;"></div>
    <div id="layoutSidenav">
        <?php include_once($url."sidebar.php"); ?>
        <div id="layoutSidenav_content">
            <main class="mt-5"> 
                <div class="container">  
                    <h4 class="mb-4 mt-5 dashboard-text">
                        <i class="fa fa-dashboard">&nbsp; </i> Dashboard as of  <?php echo $monthName . ' ' . $day. ', '. $year; ?>
                    </h4>
                    <section class="content-wrapper h-100">
                        <div id="dashboard" class="row gx-2 h-100">
                            <div class="col-12 col-lg-7 col-xl-8">
                                <div class="row g-2">
                                    <div class="banner col-12">
                                        <div class="card position-relative p-2 gradient-bg border-0 section-banner" style="z-index: 2;">
                                            <div class="card-body d-flex justify-content-between text-white">
                                                <div>
                                                    <h5 class="title">Hello, <?php echo $fullname; ?></h5>
                                                    <p class="subtitle">Welcome to e-voting system. In a University Faculty Election all faculty members at DHVSU are required to vote. Check how voting is carried out in your organization.
                                                    <a class="text-yellow" role="button" data-bs-toggle="modal" data-bs-target="#guideModal">Guide</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card border-0 bg-light-orange">
                                            <h4 class="candidates-title m-3">Candidates</h4>
                                            <div class="row mx-3">
                                                <div class="col-12 col-lg-12">
                                                    <h5 class="candidates-header fw-bold bg-red text-white text-center p-2 mb-0">Faculty Election</h5>
                                                    <?php if($status =='In-Progress'){ ?>

                                                    <div id="carouselCandidatesUSC" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                        <div class="carousel-inner rounded-3">
                                                            <?php
                                                                    $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name, a.position, 
                                                                                       a.platform, a.party_name, a.election_id, a.dept_id, a.year, b.position_name, a.profile_pic
                                                                                FROM tbl_candidates a  
                                                                                LEFT JOIN (SELECT position_name, position_id FROM tbl_position WHERE election_type='FCE') b
                                                                                ON b.position_id = a.position
                                                                                WHERE a.election_id='$id_election1'";
                                                                    $result = mysqli_query($db, $sql);         

                                                                    $cnt = 1;
                                                                    while($row    = mysqli_fetch_assoc($result)) {

                                                                        $seq_no               = $cnt++;
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
                                                            <div class="carousel-item <?php if($seq_no =="1"){ echo"active";}else{echo"";} ?> py-3 card shadow border-0 p-3 text-center candidate">
                                                                
                                                                <?php if($profile_pic_v !=''){?>
                                                                    <img width="50px" height="50px" class="avatar-image rounded-circle py-2" src="<?php echo "../".$profile_pic_v; ?>" alt="Image">
                                                                <?php } else {?>
                                                                    <img class="avatar-image rounded-circle" src="../img/speech.png" alt="Image">
                                                                <?php }?>  
                                                                <div class="details">
                                                                    <h4 class="candidate_name"><?php echo $candidate_name; ?></h4>
                                                                    <p class="candidate_position"><?php echo $post_name; ?></p>
                                                                    <div class="party-holder">
                                                                        <p class="party_title text-muted m-1" style="font-size: 13px;">Partylist</p>
                                                                        <p class="candidate_party"><?php echo $party_name; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselCandidatesUSC" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselCandidatesUSC" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                    <?php }else { ?>
                                                        <div class="alert alert-warning" role="alert" id="not-selected">
                                                            <h3 class="fw-bold text-center"><i class="fas fa-exclamation-circle">&nbsp;</i> No Election In-Progress</h3>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12 mb-2">
                                        <div class="d-flex align-items-center flex-wrap py-2 px-3 bg-light-orange">
                                            <div class="me-3">
                                                <img src="../img/candidate.png" alt="" class="img-fluid mr-2 my-2" style="height: 110px;">
                                            </div>
                                            <div>
                                                <h6>Faculty Election</h6>
                                                <p class="text-ellipsis small">A group of volunteer faculty members working together to provide a means for faculty assistance in school affairs and activities, give opportunities for faculty members experience in leadership and encourage faculty relations.</p>
                                                <a href="<?php echo $url; ?>faculty-dashboard/candidates/" id="viewCandidates" class="btn btn-outline-yellow btn-sm">view all candidates</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile col-12 col-lg-5 col-xl-4 d-flex flex-column h-100 mt-lg-0 mt-sm-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="title">My Profile</h5>

                                        <small class="subtitle text-muted">Student ID: <?php echo $username_id; ?></small>

                                        <div class="text-center">
                                            <div class="avatar position-relative mx-auto my-4">
                                            <?php if($profile_pic !=''){?>
                                                <img class="position-relative rounded-circle me-2 img-fluid" src="<?php echo $url . $profile_pic; ?>" alt="Image">
                                            <?php } else {?>
                                                <img src="https://placekitten.com/400/400" class="position-relative rounded-circle me-2 img-fluid">
                                            <?php }?>
                                            </div>
                                            <h6 class="prof_name mb-1"><?php echo $fullname; ?></h6>
                                            <p class="prof_email text-muted fs-6"><?php echo $email; ?></p>
                                        </div>
                                        <div class="my-5">
                                            <h5 class="mb-3">Student Information</h5>
                                            <ul class="list-unstyled">
                                                <li>
                                                    <h6 class="prof_name mb-0">Last Name</h6>
                                                    <p class="subtitle"><?php echo $last_name; ?></p>
                                                </li>
                                                <li>
                                                    <h6 class="prof_name mb-0">First Name</h6>
                                                    <p class="subtitle"><?php echo $first_name; ?></p>
                                                </li>
                                                <li>
                                                    <h6 class="prof_name mb-0">Middle Name</h6>
                                                    <p class="subtitle"><?php echo $middle_name; ?></p>
                                                </li>
                                                <li>
                                                    <h6 class="prof_name mb-0">Department</h6>
                                                    <p class="subtitle"><?php echo $dept_name; ?></p>
                                                </li>
                                            </ul>
                                        </div>
                                
                                        <div class="position-relative btn-holder mt-auto">
                                            <div class="arrow"></div>
                                            <?php if($my_status_vote_fce == 'Y') { ?>
                                                <a class="btn btn-orange btn-custom btn-md w-100 mt-3 disabled" aria-disabled="true" href="../faculty-dashboard/faculty-vote/" role="button">Voted for Faculty Election</a>
                                            <?php } else if($my_status_vote_fce == 'A') { ?>
                                                <a class="btn btn-orange btn-custom btn-md w-100 mt-3 disabled" aria-disabled="true" href="../faculty-dashboard/faculty-vote/" role="button">Abstained from Voting</a>
                                            <?php } else { ?>
                                            <a class="btn btn-orange btn-custom btn-md w-100 mt-3" href="../faculty-dashboard/faculty-vote/" role="button">Vote for Faculty Election</a>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>    <br>
            <?php include($url.'footer.php'); ?>  
        </div>

        <!-- Modal -->
        <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="guideModalLabel">Steps in Voting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ol>
                        <li>Know all the Candidates</li>
                        <li>Select the Respective Voting Section</li>
                        <li>Fill up the ballot of your preferred candidate every position.</li>
                        <li>Submit your vote</li>
                        <li>Wait for the Email Notification as a verification of your vote.</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <?php if($my_status_vote_fce == 'Y') { ?>
                            <a class="btn btn-orange btn-custom btn-md mt-3 disabled" aria-disabled="true" href="../faculty-dashboard/faculty-vote/" role="button">Voted for Faculty Election</a>
                        <?php } else if($my_status_vote_fce == 'A') { ?>
                            <a class="btn btn-orange btn-custom btn-md mt-3 disabled" aria-disabled="true" href="../faculty-dashboard/faculty-vote/" role="button">Abstained from Voting</a>
                        <?php } else { ?>
                            <a class="btn btn-orange btn-custom btn-md mt-3" href="../faculty-dashboard/faculty-vote/"    role="button">Vote for Faculty Election</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($db); ?>
