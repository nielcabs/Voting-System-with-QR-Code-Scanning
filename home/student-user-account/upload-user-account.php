<?php
    if (!isset($_SESSION)) { 
        session_start(); 
    } 
  
    $url                = "../../";
    $urlpic             = "../../";
    $addBack 	        = '../home/';
    include_once($url.'connection/mysql_connect.php');
    require_once $url.'spreadsheet/vendor/autoload.php';

    $username_id         = $_SESSION['username_id'];
    $access_rights       = $_SESSION['access_rights'];
    $fullname            = $_SESSION['fullname'];
    $department          = $_SESSION['department'];
    $chg_password        = $_SESSION['chg_password'];
 
    if (!isset($_SESSION['E_Voting_System'])){
            header("Location:../");
    }

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
    
        <main> 
            <div class="container">  
                <h4 class="mt-5 mb-4">
                    Upload Voter Accounts
                </h4>

                <div class="card shadow mb-4">
                    <!-- <div class="card-header py-3"><h4 class="m-0 font-weight-bold text-blue"><i class="fas fa-file-import"></i>&nbsp;IMPORT USER ACCOUNTS</h4></div> -->
                    <div class="card-body mb-n4">

                        <div class="form-group mb-3">
                            <form method="POST" enctype="multipart/form-data">
                                <!-- <input type="file" id="pfilename" name="pfilename" class="input-file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <input type="submit" name="fileup" class="btn btn-secondary btn-sm" value="Fetch" /> -->
                                <div class="input-group col-sm-8">
                                    <label class="input-group-btn">
                                        <span class="btn btn-success rounded-0 btn-green btn-sm">
                                            Browse Excel File&hellip;<input type="file" id="pfilename" name="pfilename" style="display: none;" class="form-control-sm custom-file-label" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </span>
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="imprt_input" placeholder="Choose File" readonly>
                                    <span class="input-group-btn">
                                        <button name="fileup" id="fileup" class="btn btn-orange btn-reset rounded-0 btn-sm" type="submit">Upload</button>
                                    </span>
                                </div>
                            </form>
                        </div>

                        <!-- BUTTONS -->
                        <div class="form-group col-sm-12">
                            <!-- <button id="cmdvalidate" name="cmdvalidate" type="submit" class="btn btn-orange btn-sm mb-2" style="padding-left: 25px;padding-right: 25px;">VERIFY DATA</button> -->
                            <button id="cmdimport" name="cmdimport" type="submit" class="btn btn-orange btn-sm mb-2" style="padding-left: 24px;padding-right: 24px;">IMPORT</button>
                            <!-- <button id="cmd_rev_error" name="cmd_rev_error" data-toggle="modal" data-target="#myModalError" type="button" class="btn btn-orange btn-sm mb-2" disabled>REVIEW ERROR</button> -->
                        </div>

                        <div class="table-responsive">
                            
                            <table class="table table-bordered table-hover table-light tableDark table-sm" id="dttables">
                                <thead class="table-secondary text-center th-fs">
                                    <tr class="">
                                        <th class="text-center align-middle" width="11%">Student ID/No.</th>
                                        <th class="text-center align-middle" width="11%">First Name</th>
                                        <th class="text-center align-middle" width="11%">Middle Name</th>
                                        <th class="text-center align-middle" width="11%">Last Name</th>
                                        <th class="text-center align-middle" width="11%">Email</th>
                                        <th class="text-center align-middle" width="11%">Department</th>
                                        <th class="text-center align-middle" width="11%">Year</th>
                                        <th class="text-center align-middle" width="11%">Section</th>
                                    </tr>
                                <thead>
                                <tbody class="text-black">
                                
                                    <?php
                                        $path       = "empty.xlsx";
                                        $path2      = "empty.xlsx";
                                        $file_name  = "";
                                        if(isset($_POST['fileup'])) {

                                            $path       = $_FILES['pfilename']['tmp_name'] ? $_FILES['pfilename']['tmp_name'] :  $path2;
                                            
                                            $file_name  = $_FILES['pfilename']['name'];
                                        }
                                        echo'<input type="hidden" id="filename" name="filename" value="'.$path.'">';  
                                        echo'<input type="hidden" id="file_name" name="file_name" value="'.$file_name.'">'; 

                                        $reader         = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                                        $spreadsheet    = $reader->load($path);
                                        $sheetData      = $spreadsheet->getActiveSheet()->toArray();

                                        $count = 0;
                                        for ($i=1; $i<count($sheetData); $i++) {

                                            $count++;
                                            $student_id         = $sheetData[$i][0];
                                            $first_name         = $sheetData[$i][1];
                                            $middle_name        = $sheetData[$i][2];
                                            $last_name          = $sheetData[$i][3];
                                            $email              = $sheetData[$i][4];
                                            $dept_id            = $sheetData[$i][5];
                                            $year               = $sheetData[$i][6];
                                            $section            = $sheetData[$i][7] ?? null;
                                        
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $student_id; ?>
                                            <input type="hidden" id="student_id<?php echo $count; ?>" name="student_id<?php echo $count; ?>" value="<?php echo $student_id; ?>">
                                        </td>
                                        <td class="text-left"><?php echo $first_name; ?>
                                            <input type="hidden" id="first_name<?php echo $count; ?>" name="first_name<?php echo $count; ?>" value="<?php echo $first_name; ?>">
                                        </td>
                                        <td class="text-left"><?php echo $middle_name; ?>
                                            <input type="hidden" id="middle_name<?php echo $count; ?>" name="middle_name<?php echo $count; ?>" value="<?php echo $middle_name; ?>">
                                        </td>
                                        <td class="text-left"><?php echo $last_name; ?>
                                            <input type="hidden" id="last_name<?php echo $count; ?>" name="last_name<?php echo $count; ?>" value="<?php echo $last_name; ?>">
                                        </td>
                                        <td class="text-left"><?php echo $email; ?>
                                            <input type="hidden" id="email<?php echo $count; ?>" name="email<?php echo $count; ?>" value="<?php echo $email; ?>">
                                        </td>
                                        <td class="text-center"><?php echo $dept_id; ?>
                                            <input type="hidden" id="dept_id<?php echo $count; ?>" name="dept_id<?php echo $count; ?>" value="<?php echo $dept_id; ?>">
                                        </td>
                                        <td class="text-center"><?php echo $year; ?>
                                            <input type="hidden" id="year<?php echo $count; ?>" name="year<?php echo $count; ?>" value="<?php echo $year; ?>">
                                        </td>
                                        <td class="text-center"><?php echo $section; ?>
                                            <input type="hidden" id="section<?php echo $count; ?>" name="section<?php echo $count; ?>" value="<?php echo $section; ?>">
                                        </td>
                                    
                                    </tr>
                                    <?php
                                        }
                                        $len = $count;
                                    ?>
                                    <input type="hidden" id="len" name="len" value="<?php echo $len; ?>">
                                    
                                </tbody>
                                
                            </table>
                            <a id="" href="../student-user-account" type="button" class="btn btn-secondary px-4">Go Back to Student Accounts</a>
                        </div>
                       
                    </div>
                </div>
  

                
            </div>
        </main>     
        <?php include($url.'footer.php'); ?>   
    </div>
</div>

<script>

    //ImportFuncton
    function importData() {
 
        var count          = $("#len").val();
        var i              = 1;
        var student_data   = [];

        for(i = 1; i <= count; i++){

            var  student_id       =   $("#student_id"+[i]).val();
            var  first_name       =   $("#first_name"+[i]).val();
            var  middle_name      =   $("#middle_name"+[i]).val();
            var  last_name        =   $("#last_name"+[i]).val();
            var  email            =   $("#email"+[i]).val();
            var  dept_id          =   $("#dept_id"+[i]).val();
            var  year             =   $("#year"+[i]).val();
            var  section          =   $("#section"+[i]).val();

            student_data[i]       =   student_id + 
                                '|' + first_name + 
                                '|' + middle_name +
                                '|' + last_name +
                                '|' + email +
                                '|' + dept_id +
                                '|' + year +
                                '|' + section;
        }

        var pushToPost         = student_data.join('~');
   
        $('#myloader').show();
        $.ajax({
        
            type: 	"POST",
            url	:   'saveImport.php',
            data:{      "pushToPost"         :   pushToPost,
                        "count"              :   count

            },
            success : function(response) {
                $('#myloader').hide();
                var myresponse = response.split('|');  
             
                if ($.trim(myresponse[0]) == 'Relogin') { 
                    Swal.fire({
                            title: "Unable to save record, Your session has expired. Please re-login.",
                            text: "",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'NO',
                            allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            location.reload();
                        }
                    })
                } else if ($.trim(myresponse[0]) === 'already exist.') {
                    Swal.fire('Student Number: '+ $.trim(myresponse[1]) +'','', 'error') 
                    $('#cmdimport').prop("disabled", false);
                } else if ($.trim(myresponse[0]) === 'email_exist') {
                    Swal.fire('Email Address: '+ $.trim(myresponse[1]) +' already exist','', 'error') 
                    $('#cmdimport').prop("disabled", false);
                } else if ($.trim(myresponse[0]) === 'deptidnotfoundindatabase') {
                    swal.fire("Department ID doesn't exist, Kindly check your excel data.",'','error')
                    $('#cmdimport').prop("disabled", false);
                } else if ($.trim(myresponse[0]) === 'Imported Successfully!') {
                    
                    Swal.fire({
                            title: "Successfully Saved.",
                            text: "",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#4e73df',
                            cancelButtonColor: '#858796',
                            confirmButtonText: 'OK',
                            cancelButtonText: 'NO',
                            allowOutsideClick: false
                    }).then((isConfirm) => {
                        if (isConfirm.value) {
                            
                            $("#fileup").click();
                        }
                    })
                } else if ($.trim(myresponse[0])=="Error importing data.") {
                    swal.fire($.trim(myresponse[0]),'','error')
                } else {
                    Swal.fire('Error Importing.','', 'error') 
                    $('#cmdimport').prop("disabled", false);  
                }
                
            },
                error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                $('#myloader').hide();
                swal.fire('Oops...','Please check your internet connection and try again.','error')
            }

        });//endAJAX
        
    }//endImportFunction

    // SAVE
    $("#cmdimport").click(function(){

        var filename                = $("#filename").val();

       if(filename == 'empty.xlsx'){
          Swal.fire('Please Select File.','', 'error')
        } else {
              Swal.fire({
                    title: 'IMPORT DATA',
                    text: "Are you sure you want to import this data?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'YES',
                    cancelButtonText: 'NO',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: function() {
                      return new Promise(function(resolve) {
                        setTimeout(function() {
                          resolve()
                          importData();
                        }, 2000)
                      })
                    }
              })
        }      
    });//endSave




    $("#imprt_input").click(function(){
        $("#pfilename").click();
    });

</script>


</body>
</html>

<script>

    $(function() {
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });

    });

</script>

<?php mysqli_close($db); ?>
