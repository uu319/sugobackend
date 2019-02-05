<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['option_name'])){
		$model = new Model();
		$result = $model->getErrandOptionDescription($_POST['option_name']);
		if(count($result) > 0){
		    foreach($result as $res){
		        $data [] = $res;
		        $req = explode(",", $res['option_description']);

		        $req2 [] = array('option_id'=>$res['option_id'], 'option_name'=>$res['option_name'], 'option_description'=>$req, 'errand_category_id'=>$res['errand_category_id']);
		    }

		    $return ['msg'] = $req2;
		    $return ['error'] = false;
		}
		else{
		    $return ['msg'] = 'No errand document yet';
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
