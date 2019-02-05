<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['username']) &&
		isset($_POST['type'])){

        $model = new Model();
        $result = $model->getUserErrandsByUsername($_POST['username'], $_POST['type']);
        if(count($result) > 0){
            foreach($result as $res){
                $data[] = $res;
            }
            $return ['msg'] = $data;
            $return ['error'] = false;
        }
        else{
            $return ['msg'] = 'No errand';
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
