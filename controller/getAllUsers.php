<?php

require "../model/model.php";

$return = array();

$model = new Model();
$result = $model->getAllUsers();
if(count($result) > 0){
    foreach($result as $res){
        $data [] = $res;
    }
    $return ['msg'] = $data;
    $return ['error'] = false;
}
else{
    $return ['msg'] = 'No data found';
    $return ['error'] = true;
}

echo json_encode($return);



?>