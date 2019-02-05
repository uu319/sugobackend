<?php

require '../model/Model.php';

$return = array();
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['username']) &&
		isset($_POST['option_id']) &&
		isset($_POST['status'])){

		$model = new Model();
		if($_POST['status'] == "offered"){
			$delete = $model->unofferServiceByUsername($_POST['username'], $_POST['option_id']);
			if($delete == 0){
				$return ['msg'] = "Service offered removed successfully";
				$return ['error'] = false;
			}
			else{
				$return ['msg'] = "Failed to remove service offered";
				$return ['error'] = true;
			}
		}
		else{
			$add = $model->offerServiceByUsername($_POST['username'], $_POST['option_id']);
			if($add == 0){
				$return ['msg'] = "Service offered added successfully";
				$return ['error'] = false;
			}
			else{
				$return ['msg'] = "Failed to add service offered";
				$return ['error'] = true;
			}
		}

	}
	else{
		$return ['msg'] = "Something went wrong";
		$return ['error'] = true;
	}
}
else{
	$return ['msg'] = "Invalid request";
	$return ['error'] = true;
}

echo json_encode($return);


?>
