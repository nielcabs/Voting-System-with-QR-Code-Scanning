
<?php 
include_once('../../connection/mysql_connect.php'); 


?>
<!-- The Modal -->
<div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="uploadUsers">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h5 class="modal-title fw-bold"><span id="modal_title"></span> Upload Student Voter Accounts</h5>
        <button id="closeModal1" type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

            <!-- Modal body -->
            <div class="modal-body">

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
                                            Browse Excel File&hellip;<input type="file" id="pfilename" name="pfilename" style="display: none;" class="form-control-sm" accept="application/vnd.ms-excel">
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
                            <button id="cmdvalidate" name="cmdvalidate" type="submit" class="btn btn-orange btn-sm mb-2" style="padding-left: 25px;padding-right: 25px;">VALIDATE</button>
                            <button id="cmdimport" name="cmdimport" type="submit" class="btn btn-orange btn-sm mb-2" style="padding-left: 24px;padding-right: 24px;" disabled>IMPORT</button>
                            <button id="cmd_rev_error" name="cmd_rev_error" data-toggle="modal" data-target="#myModalError" type="button" class="btn btn-orange btn-sm mb-2" disabled>REVIEW ERROR</button>
                        </div>

                        <div class="col-lg-12">                    
                            <div class="table-responsive">
                                
                                <table class="table table-striped_new table-bordered nowrap" id="fixTable" width="100%" cellspacing="0">
                                    <thead class="text-black">
                                    <tr class="myHead">
                                        <th>Student ID/No.</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                    </tr>
                                    <thead>
                                    <tbody class="text-black">
                                    
                                        <?php

                                            if(isset($_POST['fileup'])) {
                                                    $path = $_FILES['pfilename']['tmp_name'];
                                                    $file_name = $_FILES['pfilename']['name'];
                                            }
                                            echo'<input type="hidden" id="filename" name="filename" value="'.$path.'">';  
                                            echo'<input type="hidden" id="file_name" name="file_name" value="'.$file_name.'">'; 
                                        $count = 0;
                                        $data = new Spreadsheet_Excel_Reader($path);
                                        for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
                                        {    
                                            
                                            if(count($data->sheets[$i]['cells'])>0){ // checking sheet not empty
                                                
                                                for($j=2;$j<=count($data->sheets[$i]['cells']);$j++){ // loop used to get each row of the sheet
                                                    
                                                    for($k=1;$k<=count($data->sheets[$i]['cells'][$j]);$k++){ // This loop is created to get data in a table format.
                                                        
                                                        $html.=$data->sheets[$i]['cells'][$j][$k];
                                                        
                                                    }
                                                    $count++;
                                                    $seq_no        = ($data->sheets[$i]['cells'][$j][1]);
                                                    $tin           = ($data->sheets[$i]['cells'][$j][2]);
                                                    $corp_name     = ($data->sheets[$i]['cells'][$j][3]);
                                                    $lname         = ($data->sheets[$i]['cells'][$j][4]);
                                                    $fname         = ($data->sheets[$i]['cells'][$j][5]);
                                                    $mname         = ($data->sheets[$i]['cells'][$j][6]);
                                                    $atc           = ($data->sheets[$i]['cells'][$j][7]);

                                                    if (strpos($aip,',') !== false) { 
                                                    $aip = str_replace(',', '', $aip);
                                                    }
                                                    if (strpos($taxwitheld,',') !== false) { 
                                                    $taxwitheld = str_replace(',', '', $taxwitheld);
                                                    }


                                                    if (strpos($aip, "(") !== false && strpos($aip, ")") !== false){
                                                    $aip = '-'. trim($aip, "()");
                                                    }
                                                        
                                                    if (strpos($taxwitheld, "(") !== false && strpos($taxwitheld, ")") !== false){
                                                    $taxwitheld = '-'. trim($taxwitheld, "()");
                                                    }

                                                    if (strpos($aip,'* ') !== false) { 
                                                    $aip = str_replace('* ', '', $aip);
                                                    }
                                                    if (strpos($taxwitheld,'* ') !== false) { 
                                                    $taxwitheld = str_replace('* ', '', $taxwitheld);
                                                    }


                                                    $total_tax_withheld += $taxwitheld;
                                            
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $seq_no; ?>
                                                <input type="hidden" id="seq_no<?php echo $count; ?>" name="seq_no<?php echo $count; ?>" value="<?php echo $seq_no; ?>">
                                            </td>
                                            <td class="text-center"><?php echo $tin; ?>
                                                <input type="hidden" id="tin<?php echo $count; ?>" name="tin<?php echo $count; ?>" value="<?php echo $tin; ?>">
                                            </td>
                                            <td class="text-left"><?php echo $corp_name; ?>
                                                <input type="hidden" id="corp_name<?php echo $count; ?>" name="corp_name<?php echo $count; ?>" value="<?php echo $corp_name; ?>">
                                            </td>
                                            <td class="text-left"><?php echo $lname; ?>
                                                <input type="hidden" id="lname<?php echo $count; ?>" name="lname<?php echo $count; ?>" value="<?php echo $lname; ?>">
                                            </td>
                                            <td class="text-left"><?php echo $fname; ?>
                                                <input type="hidden" id="fname<?php echo $count; ?>" name="fname<?php echo $count; ?>" value="<?php echo $fname; ?>">
                                            </td>
                                            <td class="text-left"><?php echo $mname; ?>
                                                <input type="hidden" id="mname<?php echo $count; ?>" name="mname<?php echo $count; ?>" value="<?php echo $mname; ?>">
                                            </td>
                                            <td class="text-center"><?php echo $atc; ?>
                                                <input type="hidden" id="atc<?php echo $count; ?>" name="atc<?php echo $count; ?>" value="<?php echo $atc; ?>">
                                            </td>
                                        
                                        </tr>
                                        <?php
                                            
                                                } 
                                            }
                                        } 
                                        $len = $count;
                                        
                                        ?>
                                       
                                    </tbody>
                                    
                                </table>
                            
                            </div>
                        </div> 

                    </div>
                </div>

            </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button id="btnSaveUpload" id="" type="button" class="btn btn-orange">Save</button>
            <button id="closeModal2" id="" type="button" class="btn btn-red" data-bs-dismiss="modal">Cancel</button>
        </div>

    </div>
  </div>
</div>


