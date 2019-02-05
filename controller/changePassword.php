<?php

require "../model/model.php";

$return = array();
$username = "";
$password = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['new_password']) &&
        isset($_POST['retype_newpassword']) &&
        isset($_POST['current_password']) &&
        isset($_POST['username'])){ //pwede rani wala kay isession man ang username, try rani

            $newPassword = $_POST['new_password'];
            $retypeNewPassword = $_POST['retype_newpassword'];
            $currentPassword = $_POST['current_password'];
            $username = $_POST['username']; //kung naka isession na gani ang user e $_SESSION['username'] lang

            $model = new Model();
            $getUserInfo = $model->getUserByUsername($username);
            if(count($getUserInfo) > 0){
                foreach($getUserInfo as $getInfo){
                    $myPassword = $getInfo ['password'];
                }
                if($currentPassword != $myPassword){
                    $return ['msg'] = 'Incorrect current password';
                    $return ['error'] = true;
                }
                else{
                    $result = $model->changePassword($username, $newPassword);
                    // print_r($result); exit();
                    if($result == 0){
                        $return ['msg'] = 'Change password success';
                        $return ['error'] = false;
                    }
                    else{
                        $return ['msg'] = 'Change password failed';
                        $return ['error'] = true;
                    }
                }
            }
            else{
                $return ['msg'] = 'Something went wrong';
                $return ['error'] = true;
            }
            
    }
    else{
            $return ['msg'] = 'Something went wrong';
            $return ['error'] = true;
    }
}
else{
    $return ['msg'] = 'Invalid Request';
    $return ['error'] = true;
}

echo json_encode($return);



?>