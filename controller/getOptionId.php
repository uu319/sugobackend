<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['option_name'])){
		$model = new Model();
		$result = $model->getOptionId($_POST['option_name']);
		if(count($result) > 0){

		    $return ['msg'] = $result;
		    $return ['error'] = false;
		}
		else{
		    $return ['msg'] = 'No id';
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
