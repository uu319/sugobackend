<?php

require "../model/Model.php";

date_default_timezone_set('Asia/Manila');

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['errand_id'])){

        $status = 'accepted';

        $model = new Model();
        $result = $model->updateErrandStatus($_POST['errand_id'], $status);
        if($result == 0){
            $return ['msg'] = 'Errand accepted';
            $return ['error'] = false;
            $optionName = $model->getUserErrandsByErrandId($_POST['errand_id']);
            foreach($optionName as $op){
            $description = "You have accepted the errand ".$op['errand_name']."{".$op['option_name']."}";
            $description2 = "Your posted errand ".$op['errand_name']."{".$op['option_name']."} has been accepted";
            $toNofification = $model->toNofification($op['erunner_username'], $description, date('Y-m-d H:i:s'), $_POST['errand_id']);
            $toNofification = $model->toNofification($op['eseeker_username'], $description2, date('Y-m-d H:i:s'), $_POST['errand_id']);
            // if($toNofification){
            //     echo "OK";
            // }else echo "FAILED";
            }
        }
        else{
            $return ['msg'] = 'Failed to accept errand';
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
}
