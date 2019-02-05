<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['option_id'])){
		$model = new Model();
		$result = $model->getPaymentDetails($_POST['option_id']);
		if(count($result) > 0){
		    foreach($result as $res){
		    	$data[] = $res;
		    	$rate = $res['rate_per_hour'];
		    	$fee = $res['booking_fee'];
		    }

		    $return ['msg'] = $data;
		    $return ['error'] = false;
		}
		else{
		    $return ['msg'] = 'No rate per hour';
		    $return ['error'] = true;
		}
	}
	else{
		$return ['msg'] = 'Something went wrong!';
		$return ['error'] = true;
	}
}
else{
	$return ['msg'] = 'Invalid request';
	$return ['error'] = true;
}

echo json_encode($return);



?>
