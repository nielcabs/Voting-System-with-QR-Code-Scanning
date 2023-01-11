
<?php 
include_once('../../connection/mysql_connect.php'); 


$rec_id   = $_POST['rec_id'] ?? '';
?>
<!-- The Modal -->
<div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="viewUserModal">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Party</h5>
        <button id="closeModal1" type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
            <input id="rec_id" type="hidden" value="<?php echo $rec_id; ?>">
            <input id="action" type="hidden" value="Add">
            <div class="row">



                <div class="col-sm-12 mb-1">
                    <label for="party_name" class="form-label-sm fw-bold">Party Name</label>
                    <input id="party_name" type="text" class="form-control form-control-sm"  placeholder="Party Name"  required>
                    <div class="invalid-feedback"> Please enter Party Name</div>
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="election_type" class="form-label-sm fw-bold">Election Type</label>
                    <select id="election_type" class="form-select form-select-sm" required>
                       <option value="" selected disabled>Select Election Type</option>
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
                    <select id="department" class="form-select form-select-sm" >
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
                    <select id="election_id" class="form-select form-select-sm election_id" required>
                       <option value="" selected disabled>Select Election</option>
                    
                    </select>
                    <div class="invalid-feedback"> Please enter Election</div>
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


