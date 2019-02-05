<?php

require "../model/Model.php";

$return = array();

$model = new Model();
$result = $model->getAllErrand();
if(count($result) > 0){
    foreach($result as $res){
        $data [] = $res;
    }
    $return ['msg'] = $data;
    $return ['error'] = false;
}
else{
    $return ['msg'] = 'No errand category yet';
    $return ['error'] = true;
}

echo json_encode($return);



?>