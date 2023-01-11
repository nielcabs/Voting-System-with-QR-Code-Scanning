<?php

    if (!isset($_SESSION)) { 
      session_start(); 
    }
    include_once($url.'connection/mysql_connect.php');

    $username_id        = $_SESSION['username_id'];
    $access_rights      = $_SESSION['access_rights'];
    $f_name             = $_SESSION['first_name'];
    $m_name             = $_SESSION['middle_name'];
    $l_name             = $_SESSION['last_name'];
    $fullname           = $_SESSION['fullname'];
    $chg_password       = $_SESSION['chg_password'];
    //$department       = $_SESSION['department'];

?>

<?php

    $fname_explode = explode(". ","$fullname");

    $fname = $fname_explode[0];
    $fname_ex = explode(" ","$fname");

    $first_name = $fname_ex[0];
    $m_initials = $fname_ex[1];
    $last_name = $fname_explode[1];

    if (strpos($last_name,' ') !== false) { 
      $lname = explode(" ","$last_name");
      $last_name = $lname[0];
    }else {
      $last_name = $fname_explode[1];
    }

    $words = explode(" ", $first_name.' '. $m_initials.' '.$last_name);
    $initials = null;
    foreach ($words as $w) {
       $initials .= $w[0];
    }
    $initials;
    
    // $sql_pp     = "SELECT file_path
    //                 FROM db_users.tbl_profile_pictures
    //                 WHERE userid='$username'";
    // $res_pp     = mysqli_query($db, $sql_pp) or die (mysqli_error($db));
    // $row_pp     = mysqli_fetch_assoc($res_pp);
 
    // $pp_path  = $row_pp['file_path'];

?>

<?php 
    //if($change_comp === 'N') {

        $sql	="SELECT profile_pic
                FROM tbl_users
                WHERE username_id ='$username_id'";	
        $res       = mysqli_query($db, $sql) or die (mysqli_error($db));
        $row       = mysqli_fetch_assoc($res);

        $profile_pic           = $row['profile_pic'] ?? '';
?>

<div id="layoutSidenav_nav">
    <button class="btn btn-maroon btn-md btn-sidebar-toggle rounded-0" id="sidebarToggle" type="button"><i class="fas fa-bars fs-5 text-white"></i></button>
    <div class="fixed-top d-flex flex-column justify-content-between vh-100 py-3 sidebar bg-maroon">
        <div>
            <div class="text-center px-3">
                <img style="width: 80px;" src="<?php echo $url; ?>img/dhvsu-logo.png">
                <h5 class="nav-title text-white mt-2">E-Voting System</h5>
            </div>
            <hr/>
            <?php if($chg_password =="N") { ?>
                <ul class="sidebar-menu text-center text-md-start list-unstyled ps-0">
                    <?php   if ($access_rights =="std_admin" || $access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { ?>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link active" id="" data-sysdata="" href="<?php echo $url; ?>home/" type="button">
                                <i class="fa-solid fa-gauge"></i>
                                <span class="sidebar-menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" data-bs-toggle="collapse" data-bs-target="#election-collapse" aria-expanded="false" type="button">
                                <i class="fa-solid fa-check-to-slot"></i>
                                Election
                            </a>
                            <div class="collapse" id="election-collapse">
                                <ul class="btn-toggle-nav list-unstyled sidebar-submenu">
                                        <?php   if ($access_rights =="std_admin" || $access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { ?>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/create-election" type="button">
                                                    <i class="fa-solid fa-plus"></i>
                                                    <span class="sidebar-menu-text">Create Election</span>
                                                </a>
                                            </li>
                                        <?php   }  ?>
                                        <?php   if ($access_rights =="std_admin" || $access_rights =="SUPERADMIN") {  ?> 
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/sc-election-result" type="button">
                                                    <i class="fas fa-poll"></i></i>
                                                    <span class="sidebar-menu-text">Election Results</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/sc-statistics" type="button">
                                                    <i class="fas fa-chart-pie"></i></i>
                                                    <span class="sidebar-menu-text">Graphs</span>
                                                </a>
                                            </li>
                                        <?php   } 
                                                if ($access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { 
                                        ?> 
                                        <li>
                                            <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/fc-election-result" type="button">
                                                <i class="fas fa-poll"></i></i>
                                                <span class="sidebar-menu-text">Election Results</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/fc-statistics" type="button">
                                                <i class="fas fa-chart-pie"></i></i>
                                                <span class="sidebar-menu-text">Graphs</span>
                                            </a>
                                        </li>
                                        <?php    }  ?>
                                        <?php   if ($access_rights =="std_admin" || $access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { ?>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/verify-vote" type="button">
                                                    <i class="fas fa-user-check"></i>
                                                    <span class="sidebar-menu-text">Verify Vote</span>
                                                </a>
                                            </li>
                                        <?php    }  ?> 
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/party" type="button">
                                <i class="fas fa-handshake"></i>
                                <span class="sidebar-menu-text"> Party</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" data-bs-toggle="collapse" data-bs-target="#candidates-collapse" aria-expanded="false" type="button">
                            <i class="fa-solid fa-users"></i>
                                <span class="sidebar-menu-text">Candidates</span>
                            </a>
                            <div class="collapse" id="candidates-collapse">
                                <ul class="btn-toggle-nav list-unstyled sidebar-submenu">
                                    <?php   
                                        if ($access_rights =="std_admin" || $access_rights =="SUPERADMIN") { 
                                    ?>
                                        <li>
                                            <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/usc-candidates" type="button">
                                                <i class="fa fa-users"></i>
                                                <span class="sidebar-menu-text">University Student Council</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/sc-candidates" type="button">
                                                <i class="fa-solid fa-user-group"></i>
                                                <span class="sidebar-menu-text">Localized Student Council</span>
                                            </a>
                                        </li>
                                    <?php   }
                                        if ($access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { 
                                    ?> 
                                        <li>
                                            <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/faculty-candidates" type="button">
                                                <i class="fa-solid fa-user-tie"></i>
                                                <span class="sidebar-menu-text">Faculty Election</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" data-bs-toggle="collapse" data-bs-target="#accounts-collapse" aria-expanded="false" type="button">
                                <i class="fa-solid fa-user"></i>
                                <span class="sidebar-menu-text">Accounts</span>
                            </a>
                            <div class="collapse" id="accounts-collapse">
                                <ul class="btn-toggle-nav list-unstyled sidebar-submenu">
                                    <?php   if ($access_rights =="std_admin" || $access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { ?>
                                        <?php if ($access_rights =="std_admin" || $access_rights =="SUPERADMIN") { ?>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/student-user-account" type="button">
                                                    <i class="fa fa-users"></i>
                                                    <span class="sidebar-menu-text">Student Accounts</span>
                                                </a>
                                            </li>
                                        <?php   } 
                                            if ($access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { 
                                        ?>  
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/faculty-user-account" type="button">
                                                    <i class="fa fa-users"></i>
                                                    <span class="sidebar-menu-text">Faculty Accounts</span>
                                                </a>
                                            </li>
                                        <?php   } ?>
                                    <?php   } ?>
                                        <?php   if ($access_rights =="std_admin" || $access_rights =="SUPERADMIN") {  ?>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/student-admin-account" type="button">
                                                    <i class="fas fa-user-shield"></i>
                                                    <span class="sidebar-menu-text">Student Admin</span>
                                                </a>
                                            </li>
                                    <?php }
                                        if ($access_rights =="faculty_admin" || $access_rights =="SUPERADMIN") { 
                                    ?>
                                            <li>
                                                <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/faculty-admin-account" type="button">
                                                    <i class="fas fa-user-shield"></i>
                                                    <span class="sidebar-menu-text">Faculty Admin</span>
                                                </a>
                                            </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/add-department/" type="button">
                                <i class="fas fa-building"></i>
                                <span class="sidebar-menu-text">Department</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/add-position" type="button">
                                <i class="fas fa-user-plus"></i>
                                <span class="sidebar-menu-text"> Positions</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>home/db-backup/" type="button">
                                <i class="fas fa-database"></i>
                                <span class="sidebar-menu-text">Database Backup</span>
                            </a>
                        </li>
                    <?php   }  ?>

                    <?php   if ($access_rights =="std_voter") { ?>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link active" id="" data-sysdata="" href="<?php echo $url; ?>student-dashboard/" type="button">
                                <i class="fa-solid fa-gauge"></i>
                                <span class="sidebar-menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" href="#" data-bs-toggle="collapse" data-bs-target="#candidates-std-collapse" aria-expanded="false" type="button">
                                <i class="fa-solid fa-users"></i>
                                <span class="sidebar-menu-text">Candidates</span>
                            </a>
                            <div class="collapse" id="candidates-std-collapse">
                                <ul class="btn-toggle-nav list-unstyled sidebar-submenu">
                                    <li>
                                        <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>student-dashboard/candidates/usc/" type="button">
                                            <i class="fa-solid fa-users"></i>
                                            University Student Council
                                        </a>
                                    </li>
                                    <li>
                                        <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>student-dashboard/candidates/lsc/" type="button">
                                            <i class="fa-solid fa-users"></i>
                                            Localized Student Council
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" href="#" data-bs-toggle="collapse" data-bs-target="#votingsection-collapse" aria-expanded="false" type="button">
                                <i class="fa-solid fa-check-to-slot"></i>
                                <span class="sidebar-menu-text">Voting Section</span>
                            </a>
                            <div class="collapse" id="votingsection-collapse">
                                <ul class="btn-toggle-nav list-unstyled sidebar-submenu">
                                    <li>
                                        <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>student-dashboard/usc-vote" type="button">
                                            <i class="fas fa-vote-yea"></i>
                                            University Student Council
                                        </a>
                                    </li>
                                    <li>
                                        <a class="sidebar-submenu-link" id="" data-sysdata="" href="<?php echo $url; ?>student-dashboard/lsc-vote" type="button">
                                            <i class="fas fa-vote-yea"></i>
                                            Localized Student Council
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php    }  ?>

                    <?php   if ($access_rights =="faculty_voter") { ?>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>faculty-dashboard/" type="button">
                                <i class="fa-solid fa-gauge"></i>
                                <span class="sidebar-menu-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>faculty-dashboard/candidates" type="button">
                            <i class="fa-solid fa-users"></i>
                                <span class="sidebar-menu-text">Candidates</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item">
                            <a class="sidebar-menu-link" id="" data-sysdata="" href="<?php echo $url; ?>faculty-dashboard/faculty-vote" type="button">
                                <i class="fas fa-vote-yea"></i>
                                <span class="sidebar-menu-text">Faculty Voting Section</span>
                            </a>
                        </li>
                    <?php    }  ?>
                </ul>
            <?php } ?>
        </div>
        <div class="px-3">
            <div class="small mb-3 text-white nav-heading">Logged in as:</div>

            <a class="dropdown-toggle dropup d-flex align-items-center text-white text-decoration-none" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                <div class="avatar-circle">
                <?php if($profile_pic !=''){?>
                    <img width="35px" height="35px" class="avatar-image rounded-circle" src="<?php echo $url . $profile_pic; ?>" alt="Image">
                <?php } else {?>
                    <span class="initials"><?php  echo $initials; ?></span>
                <?php }?>
                </div>

                <div class="avatar-name mx-2 small">
                    <?php echo $fullname; ?>
                </div>

            </a>

            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-102px, 34px);">
                <li><a class="dropdown-item" href="<?php echo $url; ?>profile"><i class="fa fa-user text-primary"></i>&nbsp;Profile</a></li>
                
                <li><a class="dropdown-item" href="<?php echo $url; ?>change-password"><i class="fa-solid fa-lock text-orange"></i>&nbsp;Change Password</a></li>

                <li><hr class="dropdown-divider" /></li>

                <li><a class="dropdown-item" href="<?php echo $url; ?>logout"><i class="fa-solid fa-arrow-right-from-bracket text-danger"></i>&nbsp;Logout</a></li>
            </ul>

            <div class="form-check form-switch mt-3">
                <label class="form-check-label" for="chkbox-dark"><span class="mode-text text-white">Dark mode</span></label>

                <input onClick="setDarkMode()" class="form-check-input " type="checkbox" id="chkbox-dark">
            </div>
        </div>
    </div>
</div>

<script>
    if (localStorage.getItem('theme') == 'dark') {
        setDarkMode();
        if (document.getElementById('chkbox-dark').checked) {
            localStorage.setItem('chkbox-dark', true)      
        }
    }else{
        $('.mode-icon').addClass('fa-regular fa-moon'); 
    }

    function setDarkMode() {

        const body = document.querySelector('body'),
                     //sidebar = body.querySelector('nav'),
                     //toggle = body.querySelector(".toggle"),
                    // searchBtn = body.querySelector(".search-box"),
                    // modeSwitch = body.querySelector(".toggle-switch"),
                     modeText = body.querySelector(".mode-text");

        let isDark = document.body.classList.toggle('darkmode');
        if (isDark) {
            setDarkMode.checked = true;
            localStorage.setItem('theme', 'dark');
            document.getElementById('chkbox-dark').setAttribute('checked', 'checked');
            modeText.innerText = "Light mode";
            $('.mode-icon').addClass('fa-regular fa-sun');
            $('.nav-dark-mode').removeClass('bg-light');
            //$('#navColor').removeClass('nav-dark-mode');
            //$('.table').addClass('table-dark');
            $("#lgcLogo").attr("src","<?php echo $url; ?>img/LausGroupWhite.png");
        } else {
            setDarkMode.checked = true;
            localStorage.removeItem('theme', 'dark');
            modeText.innerText = "Dark mode";
            $('.mode-icon').removeClass('fa-regular fa-sun');
            $('.mode-icon').addClass('fa-regular fa-moon');
            $('.nav-dark-mode').addClass('bg-light');
            //$('.table').removeClass('table-dark');
            $("#lgcLogo").attr("src","<?php echo $url; ?>img/LausGroup.png");
        }
    }
 

</script>
