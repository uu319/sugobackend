<?php

require "../model/Model.php";

$return = array();
$username = "";
$password = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['username']) &&
        isset($_POST['password'])&&isset($_POST['token'])){

            $username = $_POST['username'];
            $password = $_POST['password'];
            $token =$_POST['token'];

            $model = new Model();
            $result = $model->loginUser($username, $password,$token);
            if(count($result) > 0){
                foreach($result as $res){
                    $_session['username'] = $res['username'];
                }
                if($res['status'] == 'pending' && $res['type'] == 'erunner'){
                    $return ['msg'] = 'Your account status is currently pending. Submit the requirements needed and take the interview personally first';
                    $return ['error'] = true;
                }
                else if($res['status'] == 'suspended'){
                    $return ['msg'] = 'Your account is currently suspended. You can contact the administrator for your concern';
                    $return ['error'] = true;
                }
                else if($res['status'] == 'banned'){
                    $return ['msg'] = 'Your account has been banned. You can contact the administrator for your concern';
                    $return ['error'] = true;
                }
                else{
                    $return ['msg'] = 'Login success';
                    $return ['error'] = false;
		    $return ['type']=$res['type'];
                }
            }
            else{
                $return ['msg'] = 'Login failed';
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
