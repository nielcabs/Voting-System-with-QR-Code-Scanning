<?php
$url                = "../../";
$urlpic             = "../../";
$addBack 	        = '../home/';
include_once($url.'connection/mysql_connect.php');


$elec_name   = $_POST['elec_name'] ?? '';
$dept        = $_POST['dept'] ?? '';

if ($elec_name == 'LDSC') {
    $query = "AND department ='$dept'";
} else {
    $query = "" ?? null;
}

 $get_temp = "SELECT right((election_id),3) elec_count
             FROM tbl_election
             WHERE election_name='$elec_name' $query
             ORDER BY rec_id DESC
             LIMIT 1";
$res_temp = mysqli_query($db, $get_temp) or die (mysqli_error($db));
$row_temp = mysqli_fetch_assoc($res_temp);


$elec_count = $row_temp['elec_count'] ?? '';

if($elec_count =='' || $elec_count == NULL) {
   echo $elec_count2 = "001";
} else {
    echo $elec_count2 = substr($elec_count+1001,1,3);
}


// $cnt = substr($row_temp['elec_count']+1001,1,3) ?? null;

// echo $elec_count         = ($row_temp['elec_count']!='') ? $cnt : "001";


?>