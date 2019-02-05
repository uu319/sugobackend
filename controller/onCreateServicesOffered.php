<?php

$return = array();

function onCreateServicesOffered($user_id){
	require_once('../model/Model.php');

	$model = new Model();
	$getUser = $model->getUserById($user_id);
	$allErrandOption = $model->getAllErrandOption();
	if(!empty($allErrandOption)){

		if(!empty($getUser)){
			foreach($getUser as $user){
				$username = $user['username'];
				foreach($allErrandOption as $option){
					$options[] = $option;
					$onCreateServicesOffered = $model->onCreateServicesOffered($username, $option['option_id']);
				}
			$return['msg'] = 'Services offered added';
			$return['error'] = false;
			}
		}
		else{
			$return['msg'] = 'User not found';
			$return['error'] = true;
		}
	}
	else{
		$return['msg'] = 'No errand option';
		$return['error'] = true;
	}


	echo json_encode($return);
}

// onCreateServicesOffered(12);


?>
