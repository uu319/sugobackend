<?php

require '../model/Model.php';

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['username'])){

		$model = new Model();
		$getOption = $model->getOptionStatus($_POST['username']);
		// var_dump($getOption); exit();
		if(!empty($getOption)){
			foreach($getOption as $option){
				$data[] = $option;
			}
			// $arr = array_merge($offered, $unoffered);
			$return ['msg'] = $data;
			$return ['error'] = false;
		}
		else{
			$return ['msg'] = "No service offered";
			$return ['error'] = true;
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
