<?php

require "../model/Model.php";

date_default_timezone_set('Asia/Manila');

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
          if(isset($_POST['errand_id']) &&
              isset($_POST['total_fee'])){

        $status = 'completed';

        $model = new Model();
        $result = $model->updateErrandStatusCompleted($_POST['errand_id'], $_POST['total_fee'], $status, date('Y-m-d H:i:s'));
        if($result == 0){
            $return ['msg'] = 'Errand completed';
            $return ['error'] = false;
            $optionName = $model->getUserErrandsByErrandId($_POST['errand_id']);
            foreach($optionName as $op){
            $description = "Your errand ".$op['errand_name']."{".$op['option_name']."} has been completed";
            $toNofification = $model->toNofification($op['eseeker_username'], $description, date('Y-m-d H:i:s'), $_POST['errand_id']);
            // if($toNofification){
            //     echo "OK";
            // }else echo "FAILED";
            }
        }
        else{
            $return ['msg'] = 'Failed complete errand';
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
