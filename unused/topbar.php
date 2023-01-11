<?php

    if (!isset($_SESSION)) { 
        session_start(); 
    } 
    include_once($url.'connection/mysql_connect.php');

    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];

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

<nav class="sb-topnav navbar navbar-expand xnavbar-dark bg-red xbg-dark">
    <!-- Navbar Brand-->
    <a href="../" class="pull-left title_whole"><img style="max-width: 150px; margin: 0 30px 0 10px;" src="<?php echo $url; ?>img/samp.png"></a>
    <a href="../" class="pull-left title_short"><img style="max-width: 150px; max-height: 50px; margin: 0 30px 0 10px;" src="<?php echo $url; ?>img/samp.png"></a>
    <!-- Sidebar Toggle-->

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- Navbar Search-->
    <h2 class="SysHeaderText title_whole" style="margin-left:20px; margin-right:80px; margin-top: 7px; color: #B6D0E2;"><b>E-</b> <b>V</b>oting <b>S</b>ystem</h2>
    <!--<h4 class="title_short text-center" style="margin-top: 0px; color: #B6D0E2;"><b>LGIS</b></h4>-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
<!--            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>-->
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <a href="<?php echo $url; ?>profile">

                <div class="avatar-circle mr-3">
                    <span class="initials"><?php  echo $initials; ?></span>
                </div>
 
        </a>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-102px, 34px);">

                <li><a class="dropdown-item" href="<?php echo $url; ?>profile"><i class="fa fa-user text-primary"></i>&nbsp;Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $url; ?>change-password"><i class="fa-solid fa-lock text-success"></i>&nbsp;Change Password</a></li>
                <a class="dropdown-item" href="#"> 
                        <div class="form-check form-switch">    
                            <label class="form-check-label" for="chkbox-dark"><i class="mode-icon">&nbsp;</i><span class="mode-text">Dark mode</span></label>
                            <input onClick="setDarkMode()" class="form-check-input " type="checkbox" id="chkbox-dark">
                        </div>
                </a>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="<?php echo $url; ?>logout"><i class="fa-solid fa-arrow-right-from-bracket text-danger"></i>&nbsp;Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

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