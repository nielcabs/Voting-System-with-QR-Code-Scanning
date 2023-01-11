
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
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Department</h5>
        <button id="closeModal1" type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" class="needs-validation" novalidate>
            <input id="rec_id" type="hidden" value="<?php echo $rec_id; ?>">
            <input id="action" type="hidden" value="Add">
            <div class="row">



                <div class="col-sm-12 mb-1">
                    <label for="position_id" class="form-label-sm fw-bold">Position ID</label>
                    <input id="position_id" type="text" class="form-control form-control-sm"  placeholder="Position ID"  required>
                    <div class="invalid-feedback"> Please enter Position ID</div>
                </div>

                <div class="col-sm-12 mb-1">
                    <label for="position_name" class="form-label-sm fw-bold">Position Name</label>
                    <input id="position_name" type="text" class="form-control form-control-sm"  placeholder="Position Name"  required>
                    <div class="invalid-feedback"> Please enter Position Name</div>
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


