<?php

require "../model/Model.php";

$return = array();
$username = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['username'])){

            $username = $_POST['username'];

            $model = new Model();
            $result = $model->logoutUser($username);
            if($result==0){
                $return ['msg'] = 'Logout success';
                $return ['error'] = false;
            }
            else{
                $return ['msg'] = 'Logout failed';
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
