<?php

require "../model/Model.php";

$return = array();
$userId = "";
$errandCategoryId = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['erunner_username']) &&
		isset($_POST['option_id'])){

        $username = $_POST['erunner_username'];
        $errandCategoryId = $_POST['errand_category_id'];

        $model = new Model();
        $result = $model->addServicesOffered($username, $errandCategoryId);
        if($result){
            $return ['msg'] = 'Service offer successfully added';
            $return ['error'] = false;
        }
        else{
            $return ['msg'] = 'Failed to add service offer';
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
