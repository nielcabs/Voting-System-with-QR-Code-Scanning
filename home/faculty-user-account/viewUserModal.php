
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
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Faculty Voter Accounts</h5>
        <button id="closeModal1" type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
            <input id="rec_id" type="hidden" value="<?php echo $rec_id; ?>">
            <input id="action" type="hidden" value="Add">
            <input id="old_username_id" type="hidden" value="">
            <div class="row">

                <div class="col-sm-4 mb-1">
                    <label for="username_id" class="form-label-sm fw-bold">Faculty ID No.</label>
                    <input id="username_id" type="text" class="form-control form-control-sm"  placeholder="Faculty ID No." required>
                    <div class="invalid-feedback"> Please enter Faculty ID No. </div>
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="user_password" class="form-label-sm fw-bold">Password</label>
                    <div class="input-group input-group-sm"> 
                        <input id="user_password" type="text" class="form-control form-control-sm"  placeholder="Password" readonly required>
                       <button id="btnResetPass" class="btn btn-sm btn-warning input-group-text" type="button">Reset Password</button>
                       <div class="invalid-feedback"> Please enter Password</div>
                    </div>  
                </div>

               <div class="col-sm-4 mb-1" id="div_pass">
                    <label for="new_password" class="form-label-sm fw-bold">New Password</label>
                    <input id="new_password" type="text" class="form-control form-control-sm"  placeholder="New Password">
                    <div class="invalid-feedback"> Please enter New Password</div>
                </div> 


                <div class="col-sm-4 mb-1" id="div_row"></div>

                <div class="col-sm-4 mb-1">
                    <label for="first_name" class="form-label-sm fw-bold">First Name</label>
                    <input id="first_name" type="text" class="form-control form-control-sm"  placeholder="First Name" required>
                    <div class="invalid-feedback"> Please enter First Name</div>
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="middle_name" class="form-label-sm fw-bold">Middle Name</label>
                    <input id="middle_name" type="text" class="form-control form-control-sm"  placeholder="Middle Name" required>
                    <div class="invalid-feedback"> Please enter Middle Name</div>
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="last_name" class="form-label-sm fw-bold">Last Name</label>
                    <input id="last_name" type="text" class="form-control form-control-sm"  placeholder="Last Name" required>
                    <div class="invalid-feedback"> Please enter Last Name</div>
                </div>

                <div class="col-sm-6 mb-1">
                    <label for="email" class="form-label-sm fw-bold">Email Address</label>
                    <input id="email" type="text" class="form-control form-control-sm"  placeholder="Email Address" required>
                    <div class="invalid-feedback"> Please enter Email Address</div>
                </div>

                <div class="col-sm-6 mb-1">
                    <label for="department" class="form-label-sm fw-bold">Department</label>
                    <select id="department" class="form-select form-select-sm" required>
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

   
            </div>

      </form>         

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="btnSave" id="" type="button" class="btn btn-orange">Save</button>
        <button id="closeModal2" id="" type="button" class="btn btn-red" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>


