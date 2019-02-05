<?php

require "../model/Model.php";

$return = array();
$username = "";
$password = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['city']) &&
        isset($_POST['street']) &&
        isset($_POST['barangay']) &&
        isset($_POST['education_level']) &&
        isset($_POST['contact']) &&
        isset($_POST['email']) &&
        isset($_POST['username'])){

            $city = $_POST['city'];
            $street = $_POST['street'];
            $barangay = $_POST['barangay'];
            $education_level = $_POST['education_level'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $model = new Model();
            $result = $model->changeProfile($city, $street, $barangay, $education_level, $contact, $email, $username);
            // print_r($result); exit();
            if($result == 0){
                if(isset($_POST['image'])){
		            $image= $_POST['image'];
                $upload_path="../uploads/$username.jpg";
                file_put_contents($upload_path, base64_decode($image));
                }
                $return ['msg'] = 'Saved changes';
                $return ['error'] = false;
            }
            else{
                $return ['msg'] = 'Failed to save changes';
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
