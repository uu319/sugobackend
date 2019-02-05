<?php

require "../model/model.php";

$return = array();

$model = new Model();
$result = $model->getAllActiveErunner();
if(count($result) > 0){
    foreach($result as $res){
        $return [] = $res;
    }
}
else{
    $return ['msg'] = 'No data found';
    $return ['error'] = 1;
}

echo json_encode($return);



?>