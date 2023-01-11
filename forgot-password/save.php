<?php
    $url        = "../";
    include_once($url.'connection/mysql_connect.php');

    $username            = $_POST['username'];
    $email_add           = $_POST['email_add'];

    //Check if username and email exist
    $sql_chk		= "SELECT username_id, email
                       FROM tbl_users
                       WHERE username_id = '$username' 
                       AND email ='$email_add'";	
    $res_chk        = mysqli_query($db, $sql_chk) or die (mysqli_error($db));
    $row        	= mysqli_fetch_assoc($res_chk);
    $row_cnt        = mysqli_num_rows($res_chk);	

    if ($row_cnt > 0) {

        //random pasword generate
        function randomPassword() {
            $alphabet = "abcdefghijkmnopqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ1!2@3#4$5%6^7&8*9";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
        $newPWD = randomPassword();
        
        $reset    = "UPDATE tbl_users
                     SET user_password =  OLD_PASSWORD('$newPWD'), chg_password = 'Y'
                     WHERE username_id = '$username'";
        $result   = mysqli_query($db, $reset);
        echo "Success|".$newPWD;
    } else {

       echo "NotFound|";

    }

?>
