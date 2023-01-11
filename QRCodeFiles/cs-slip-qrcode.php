<?php

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../commission-portal/CS-QRCode'.DIRECTORY_SEPARATOR;
    include('../mysql_connect.php');
    //html PNG location prefix
    $PNG_WEB_DIR            = '../commission-portal/CS-QRCode/';

    include "qrlib.php";
    $errorCorrectionLevel   = 'L';
    $matrixPointSize        = 4;


    $docID      = "CS-Slip_".$commissionNo;
    
    $filename   = $PNG_TEMP_DIR.$fname.'.png';
    $QRCode     = md5($filename.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);

    $fldName    = "Salesman/ Tipster Name.  : ".$tipster_name. "\r\n" .
                  "Commission Amount  : ".$salesman_comm. "\r\n" .
                  "CS No.  : ".$commissionNo. "\r\n" .
                  "CS Date  : ".$cs_date. "\r\n" .
                  "No. of Transaction/s Latest 12 months  : ".$num_transactions. "\r\n" .
                  "QRID  : ".$QRCode;

    $fname = $docID."_".$companyid;
        
    //---User Data---//
    //---$filename = $PNG_TEMP_DIR.md5($fldName.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png'---//;
    $filename = $PNG_TEMP_DIR.$fname.'.png';
    QRcode::png($fldName, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   


    //---Display generated file---//
    //echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  

?>