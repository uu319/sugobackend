<?php

require '../model/Model.php';

date_default_timezone_set('Asia/Manila');

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['errand_id'])){

		$status = 'cancelled';

		$model = new Model();
		$cancelErrand = $model->updateErrandStatus($_POST['errand_id'], $status);
		if($cancelErrand == 0){
			$return ['msg'] = 'Errand cancelled';
			$return ['error'] = false;

			$optionName = $model->getUserErrandsByErrandId($_POST['errand_id']);
            foreach($optionName as $op){
	            $description = "You have cancelled the errand ".$op['errand_name']."{".$op['option_name']."}";
	            $toNofification = $model->toNofification($op['eseeker_username'], $description, date('Y-m-d H:i:s'), $_POST['errand_id']);
	            // if($toNofification){
	            //     echo "OK";
	            // }else echo "FAILED";
            }
		}
		else{
			$return ['msg'] = 'Failed to cancel errand';
			$return ['error'] = true;
		}
	}
	else{
		$return ['msg'] = 'Something went wrong';
		$return ['error'] = true;
	}
}
else{
	$return ['msg'] = 'Invalid request';
	$return ['error'] = true;
}

echo json_encode($return);

?>
