
<?php 
include_once('../../connection/mysql_connect.php'); 


$rec_id   = $_POST['rec_id'] ?? '';
$uniqNo			= intval(substr(uniqid(rand(),true),0,5));



?>
<!-- The Modal -->
<div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserModal">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Election</h5>
        <button id="closeModal1" type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
            <input id="rec_id" type="hidden" value="<?php echo $rec_id; ?>">
            <input id="action" type="hidden" value="Add">
            <input id="uniqNo" type="hidden" value="<?php echo $uniqNo; ?>">
            <input id="elec_count" type="hidden" value="">
            <div class="row">

                <div class="col-sm-12 mb-1">
                    <label for="date_started" class="form-label-sm">Election Date Start</label>
                    <div class="input-group input-group-sm">   
                        <input id="date_started" name="date_started" type="text" class="form-control form-control-sm" placeholder="Election Date Start" onkeydown="return false;" required>
                        <span id="clickdate" class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <div class="invalid-feedback"> Please enter Election Date Start. </div>
                    </div>    
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="date_start_time" class="form-label-sm">Election Start Time</label>
                    <div class="input-group input-group-sm">   
                        <input id="date_start_time" name="date_start_time" type="text" class="form-control form-control-sm" placeholder="Election Start Time" onkeydown="return false;" required>
                        <span id="clickdate" class="input-group-text"><i class="fas fa-clock"></i></span>
                        <div class="invalid-feedback"> Please enter Election Start Time. </div>
                    </div>    
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="date_end" class="form-label-sm">Election Date End</label>
                    <div class="input-group input-group-sm">   
                        <input id="date_end" name="date_end" type="text" class="form-control form-control-sm" placeholder="Election Date Start" onkeydown="return false;" required>
                        <span id="clickdate2" class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <div class="invalid-feedback"> Please enter Election Date Start. </div>
                    </div>    
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="date_end_time" class="form-label-sm">Election End Time</label>
                    <div class="input-group input-group-sm">   
                        <input id="date_end_time" name="date_end_time" type="text" class="form-control form-control-sm" placeholder="Election End Time" onkeydown="return false;" required>
                        <span id="clickdate" class="input-group-text"><i class="fas fa-clock"></i></span>
                        <div class="invalid-feedback"> Please enter Election End Time. </div>
                    </div>    
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="election_name" class="form-label-sm fw-bold">Election Name</label>
                    <select id="election_name" class="form-select form-select-sm" required>
                       <option value="" selected disabled>Select Department</option>
                        <?php
                            if ($access_rights =="std_admin"){
                                $query = "WHERE election_type IN ('USC','LDSC')";     
                            } else if ($access_rights =="faculty_admin"){
                                $query = "WHERE election_type IN ('FCE')";
                            }

                            $get = "SELECT rec_id, election_type, description 
                                    FROM tbl_election_type
                                    $query";
                            $res = mysqli_query($db, $get);

                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($dept_id == $row['election_type']) {
                                    $xslctd = 'selected';
                                } else {
                                    $xslctd = '';
                                }
                             
                        ?>
                        <option value="<?php echo $row['election_type']; ?>" <?php echo $xslctd; ?>> <?php echo $row['description']; ?> </option> 
                     <?php  } ?>   
                    </select>
                    <div class="invalid-feedback"> Please enter Election name</div>
                </div>

                <div class="col-sm-12 mb-1" id="sc_local">
                    <label for="department" class="form-label-sm fw-bold">Department</label>
                    <select id="department" class="form-select form-select-sm">
                       <option value="" selected disabled>Select Department</option>
                        <?php
                          

                            $get = "SELECT rec_id, dept_id, department 
                                    FROM tbl_department";
                            $res = mysqli_query($db, $get);

                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($dept_id == $row['dept_id']) {
                                    $xslctd = 'selected';
                                } else {
                                    $xslctd = '';
                                }
                             
                        ?>
                        <option value="<?php echo $row['dept_id']; ?>" <?php echo $xslctd; ?>> <?php echo $row['department']; ?> </option> 
                     <?php  } ?>   
                    </select>
                    <div class="invalid-feedback"> Please enter Department</div>
                </div>

                

                <div class="col-sm-12 mb-1">
                    <label for="election_id" class="form-label-sm fw-bold">Election ID</label>
                    <input id="election_id" type="text" class="form-control form-control-sm"  placeholder="Election ID" readonly required>
                    <div class="invalid-feedback"> Please enter Election ID</div>
                </div>

             
               
               

               


            </div>

      </form>         

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="btnSave" id="" type="button" class="btn btn-orange"><span id="save_label">Save</span></button>
        <button id="closeModal2" id="" type="button" class="btn btn-red" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<script>
    $(function() {
        $('#date_start_time').daterangepicker({
                    timePicker : true,
                    singleDatePicker:true,
                    timePicker24Hour : false,
                    timePickerIncrement : 1,
                    timePickerSeconds : false,
                    locale : {
                        format : 'hh:mm A'
                    }
                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find(".calendar-table").hide();
        });

        $('#date_end_time').daterangepicker({
                    timePicker : true,
                    singleDatePicker:true,
                    timePicker24Hour : false,
                    timePickerIncrement : 1,
                    timePickerSeconds : false,
                    locale : {
                        format : 'hh:mm A'
                    }
                }).on('show.daterangepicker', function(ev, picker) {
                    picker.container.find(".calendar-table").hide();
        });
    })
</script>


