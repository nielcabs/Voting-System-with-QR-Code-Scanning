<?php

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../QRCodes'.DIRECTORY_SEPARATOR;
    $url    = "../../";
    include_once($url.'connection/mysql_connect.php');
    //html PNG location prefix
    $PNG_WEB_DIR            = '../../QRCodes/';

    include "qrlib.php";
    $errorCorrectionLevel   = 'L';
    $matrixPointSize        = 4;


    $docID      = $election_id1;
    
    $filename   = $PNG_TEMP_DIR.$fname.'.png';
    $QRCode     = md5($filename.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);

    $fldName    = "Election ID  : ".$election_id1 . "\r\n" .
                  "Election: ".$elec_description. "\r\n" .
                  $canvass_label. "\r\n" .
                  $title_total_a.": ".$res_cnt_a. "\r\n" .
                  $title_total_b.": ".$res_cnt_b. "\r\n" .
                  "QRID  : ".$QRCode;

    $fname = $docID;
        
    //---User Data---//
    //---$filename = $PNG_TEMP_DIR.md5($fldName.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png'---//;
    $filename = $PNG_TEMP_DIR.$fname.'.png';
    QRcode::png($fldName, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   


    //---Display generated file---//
    //echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  

?>