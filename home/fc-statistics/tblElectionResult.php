<?php 

    if (!isset($_SESSION)) { 
        session_start(); 
    }
    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];
    include_once('../../connection/mysql_connect.php'); 


    $election_id        = $_POST['election_id'] ?? ''; 
    $election_type      = $_POST['election_type'] ?? ''; 


    $sql1           = "SELECT * FROM tbl_users
        WHERE active = 'Y' and access_rights = 'std_voter'";
    $result1        = mysqli_query($db, $sql1);        

?>

<?php

    $sql    =  "SELECT a.rec_id, a.student_id, a.first_name, a.middle_name, a.last_name,
                    a.position, a.platform, a.election_id, a.dept_id, a.year, b.position_name, a.vote_count
                FROM tbl_candidates a  
                LEFT JOIN (SELECT rec_id, position_name, position_id FROM tbl_position WHERE election_type='$election_type') b
                ON b.position_id = a.position
                WHERE a.election_id='$election_id'
                ORDER BY b.rec_id";
    $result = mysqli_query($db, $sql);         

    $count = 1;
    while($row    = mysqli_fetch_assoc($result)) {

        $seq_no                 = $count++;
        $rec_id               = $row['rec_id'];
        $student_id           = $row['student_id'];
        $first_name           = $row['first_name'];
        $middle_name          = $row['middle_name'];
        $last_name            = $row['last_name'];
        $position             = $row['position'];
        $platform             = $row['platform'];
        $election_id          = $row['election_id'];
        $dept_id              = $row['dept_id'];
        $year                 = $row['year'];
        $post_name            = $row['position_name'];
        $vote_count           = $row['vote_count'] ?? "0";
        $candidate_name       = $last_name.', '.$first_name.'. '.$middle_name;


        $sql1           = "SELECT * FROM tbl_users
                            WHERE active = 'Y' and access_rights = 'faculty_voter'";
        $result1        = mysqli_query($db, $sql1);           
        $total_voter    = mysqli_num_rows($result1);

        $vote_perc      = number_format(($vote_count / $total_voter) * 100,2);

        if($position =="PD") {
            $candidate_a[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count,
            );
            $position_name_a = $post_name;
        } else if($position =="VP"){

            $candidate_b[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_b = $post_name;
        }  else if($position =="SC"){

            $candidate_c[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_c = $post_name;
        }  else if($position =="TRE"){

            $candidate_d[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_d = $post_name;
        }  else if($position =="AUD"){

            $candidate_e[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_e = $post_name;
        }  else if($position =="PRO"){

            $candidate_f[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_f = $post_name;
        }  else if($position =="SGA"){

            $candidate_g[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_g = $post_name;
        }  else if($position =="BM"){

            $candidate_h[] = array (
                'candidate_name'  => $candidate_name,
                'vote_count'      => $vote_count
            );
            $position_name_h = $post_name;
        } 
    }
        $json_candidate_a = json_encode($candidate_a);
        $json_candidate_b = json_encode($candidate_b);
        $json_candidate_c = json_encode($candidate_c);
        $json_candidate_d = json_encode($candidate_d);
        $json_candidate_e = json_encode($candidate_e);
        $json_candidate_f = json_encode($candidate_f);
        $json_candidate_g = json_encode($candidate_g);
        $json_candidate_h = json_encode($candidate_h);
?>

<script>

    function position_a(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_a", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_a').html('<?php echo $position_name_a; ?>'); 
            chart.data = <?php echo $json_candidate_a; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();


            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_b(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_b", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_b').html('<?php echo $position_name_b; ?>'); 
            chart.data = <?php echo $json_candidate_b; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_c(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_c", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_c').html('<?php echo $position_name_c; ?>'); 
            chart.data = <?php echo $json_candidate_c; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_d(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_d", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_d').html('<?php echo $position_name_d; ?>'); 
            chart.data = <?php echo $json_candidate_d; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_e(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_e", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_e').html('<?php echo $position_name_e; ?>'); 
            chart.data = <?php echo $json_candidate_e; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_f(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_f", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_f').html('<?php echo $position_name_f; ?>'); 
            chart.data = <?php echo $json_candidate_f; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_g(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_g", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_g').html('<?php echo $position_name_g; ?>'); 
            chart.data = <?php echo $json_candidate_g; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }

    function position_h(){                                  

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);

            var chart = am4core.create("chartdiv_h", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            $('#post_name_h').html('<?php echo $position_name_h; ?>'); 
            chart.data = <?php echo $json_candidate_h; ?>
                
            var series                          = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.category          = "candidate_name";
            series.dataFields.value             = "vote_count";
            series.labels.template.maxWidth     = 150;
            series.labels.template.wrap         = true;
            series.labels.template.fontSize     = 12;
            chart.legend                        = new am4charts.Legend();

            series.colors.list = [
                am4core.color("#5C0017"),
                am4core.color("#f39c12"),
                am4core.color("#f56954"),
                am4core.color("#F2F94B"),
                am4core.color("#00F034"),
            ];

        });

    }


</script>
