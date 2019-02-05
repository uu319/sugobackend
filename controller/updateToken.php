<?php

require "../model/Model.php";

$return = array();

$token = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['token'])){
        $token = $_POST['token'];
        $model = new Model();
        $result = $model->updateToken($token);
        if($result){
            $return ['msg'] = 'Token success';
            $return ['error'] = false;
        }
        else{
            $return ['msg'] = 'Something went wrong with your token';
            $return ['error'] = true;
        }
    }
    else{
            $return ['msg'] = 'Something went wrong with your token';
            $return ['error'] = true;
    }
}
else{
    $return ['msg'] = 'Invalid Request';
    $return ['error'] = true;
}

echo json_encode($return);



?>
