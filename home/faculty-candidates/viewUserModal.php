
<?php 
include_once('../../connection/mysql_connect.php'); 


$rec_id   = $_POST['rec_id'] ?? null;

?>
<!-- The Modal -->
<div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Candidate</h5>
        <button id="closeModal1" type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
            <input id="rec_id" class="rec_id" type="hidden" value="<?php echo $rec_id; ?>">
            <input id="action" class="action" type="hidden" value="Add">
            <div class="row">

                <div class="col-sm-4 mb-1">
                    <label for="student_id" class="form-label-sm fw-bold">Faculty ID No.</label>
                    <div class="input-group input-group-sm">
                        <input readonly id="student_id" type="text" class="form-control form-control-sm student_id"  placeholder="Faculty ID No." required>
                        <button id="btnSearch" class="btn btn-sm btn-orange input-group-text"  data-bs-toggle="modal" data-bs-target="#viewSearch" type="button">Search</button>
                        <div class="invalid-feedback"> Please enter Faculty ID No. </div>
                    </div> 
                </div>
                <div class="col-sm-8 mb-1"></div>

                <div class="col-sm-4 mb-1">
                    <label for="first_name" class="form-label-sm fw-bold">First Name</label>
                    <input id="first_name" type="text" class="form-control form-control-sm first_name"  placeholder="First Name" required>
                    <div class="invalid-feedback"> Please enter First Name</div>
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="middle_name" class="form-label-sm fw-bold">Middle Name</label>
                    <input id="middle_name" type="text" class="form-control form-control-sm middle_name"  placeholder="Middle Name" required>
                    <div class="invalid-feedback"> Please enter Middle Name</div>
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="last_name" class="form-label-sm fw-bold">Last Name</label>
                    <input id="last_name" type="text" class="form-control form-control-sm last_name"  placeholder="Last Name" required>
                    <div class="invalid-feedback"> Please enter Last Name</div>
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="department" class="form-label-sm fw-bold">Department</label>
                    <select id="department" class="form-select form-select-sm department" required>
                       <option value="" selected disabled>Select Department</option>
                        <?php
                          

                            $get = "SELECT dept_id, department 
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


                <div class="col-sm-6 mb-1">
                    <label for="position" class="form-label-sm fw-bold">Position</label>
                    <select id="position" class="form-select form-select-sm position" required>
                       <option value="" selected disabled>Select Position</option>
                        <?php
                          

                            $get = "SELECT election_type, position_id, position_name 
                                    FROM tbl_position
                                    WHERE election_type = 'FCE'";
                            $res = mysqli_query($db, $get);

                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($position_id == $row['position_id']) {
                                    $xslctd = 'selected';
                                } else {
                                    $xslctd = '';
                                }
                             
                        ?>
                        <option value="<?php echo $row['position_id']; ?>" <?php echo $xslctd; ?>> <?php echo $row['position_name']; ?> </option> 
                     <?php  } ?>   
                    </select>
                    <div class="invalid-feedback"> Please enter Position</div>
                </div>

                <div class="col-sm-6 mb-1">
                    <label for="election_id" class="form-label-sm fw-bold">Election ID</label>
                    <select id="election_id" class="form-select form-select-sm election_id" required>
                     
                    </select>
                    <div class="invalid-feedback"> Please enter Election</div>
                </div>

                <div class="mb-3">

                <div class="col-sm-12 mb-1">
                    <label for="party_name" class="form-label-sm fw-bold">Party</label>
                    <select id="party_name" class="form-select form-select-sm party_name" required>
                       <option value="" selected disabled>Select Party</option>
                        <?php
                          

                            $get = "SELECT *
                                    FROM tbl_party
                                    WHERE election_type = 'FCE'";
                            $res = mysqli_query($db, $get);

                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($party_name == $row['party_name']) {
                                    $xslctd = 'selected';
                                } else {
                                    $xslctd = '';
                                }
                             
                        ?>
                        <option value="<?php echo $row['party_name']; ?>" <?php echo $xslctd; ?>> <?php echo $row['party_name']; ?> </option> 
                     <?php  } ?>   
                    </select>
                    <div class="invalid-feedback"> Please select Party</div>
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="platform" class="form-label-sm fw-bold">Platform</label>
                    <textarea id="platform" class="form-control platform" rows="3" required></textarea>
                    <div class="invalid-feedback"> Please enter Last Name</div>
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="first_name" class="form-label-sm fw-bold">Upload Image</label>
                    <input class="form-control form-control-sm upload_img" type="file" id="upload_img" name="upload_img" value="" required>
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


