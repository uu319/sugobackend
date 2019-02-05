<?php

require '../model/Model.php';

$return = array();
$unoffered = array();
$offered = array();
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['username'])){

		$model = new Model();
		$getOption = $model->getOptionStatus();
		// var_dump($getOption); exit();
		if(!empty($getOption)){
			foreach($getOption as $option){
				// $data[] = $option;
				if($option['erunner_username'] == $_POST['username']){
					array_push($offered, array('option_name'=>$option['option_name'], 'status'=>'offered', 'option_id'=>$option['optionid']));
				}
				else{
					array_push($unoffered, array('option_name'=>$option['option_name'], 'status'=>'unoffered', 'option_id'=>$option['optionid']));
				}
			}
			$arr = array_merge($offered, $unoffered);
			$return ['msg'] = $arr;
			$return ['error'] = false;
		}
		else{
			$return ['msg'] = "No errand option";
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
