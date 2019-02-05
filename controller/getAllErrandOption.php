<?php

require "../model/model.php";

$return = array();

$model = new Model();
$result = $model->getAllErrandOption();
if(count($result) > 0){
    foreach($result as $res){
        $return ['msg'] = $res;
        $return ['error'] = false
    }
}
else{
    $return ['msg'] = 'No data found';
    $return ['error'] = true;
}

echo json_encode($return);



?>
