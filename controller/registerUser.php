<?php

require "../model/Model.php";

$return = array();
$firstname = "";
$middlename = "";
$lastname = "";
$age = "";
$birthdate = "";
$city = "";
$street = "";
$barangay = "";
$education_level = "";
$contact = "";
$email = "";
$username = "";
$password = "";

date_default_timezone_set('Asia/Manila');
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['firstname']) &&
        isset($_POST['middlename']) &&
        isset($_POST['lastname']) &&
        isset($_POST['birthdate']) &&
        isset($_POST['city']) &&
        isset($_POST['street']) &&
        isset($_POST['barangay']) &&
        isset($_POST['education_level']) &&
        isset($_POST['contact']) &&
        isset($_POST['email']) &&
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['type'])&&
	isset($_POST['current_location'])){ //butangi ang form sa erunner og eseeker nga user type ihidden lang

            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $lastname = $_POST['lastname'];
            $birthdate = $_POST['birthdate'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $barangay = $_POST['barangay'];
            $education_level = $_POST['education_level'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $type = $_POST['type'];

            $status = "";
            $rating = 0;
            $current_location = $_POST['current_location'];
            $report_count = 0;
$date_registered='0000-00-00 00:00:00';

            if($type == 'erunner'){
                $status = 'pending';
            }
            else{
                $status = 'active';
                $rating = '0';
                $current_location = 'N/A';
            }

            $model = new Model();
            $checkUsername = $model->usernameExists($username);
            if(count($checkUsername) < 1){
                $result = $model->registerUser($firstname, $middlename, $lastname, $birthdate, $city, $street, $barangay, $education_level, $contact, $email, $username, $password, $type, $status, $rating, $current_location, $report_count,$date_registered);
                if($result){
                  $image= $_POST['image'];
                  $upload_path="../uploads/$username.jpg";
                  file_put_contents($upload_path, base64_decode($image));
                    $return ['msg'] = 'Registration success';
                    $return ['error'] = false;
                }
                else{
                    $return ['msg'] = 'Registration failed';
                    $return ['error'] = true;
                }
            }
            else{
                $return ['msg'] = 'Username already exists';
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


if($return['error']==false){
  include "onCreateServicesOffered.php";
  $match= onCreateServicesOffered($result);
}




?>
