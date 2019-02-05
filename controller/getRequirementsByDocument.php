<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['errand_document'])){
		$model = new Model();
		$result = $model->getRequirementsByDocument($_POST['errand_document']);
		if(count($result) > 0){
		    foreach($result as $res){
		    	$data[] = $res;
		    }

		    $return ['msg'] = $data;
		    $return ['error'] = false;
		}
		else{
		    $return ['msg'] = 'No errand requirements yet';
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
