<?php

require "../model/Model.php";

$return = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['username'])){ //pwede rani wala kay isession man ang username, try rani or if isset($_SESSION'username'[])

            $username = $_POST['username']; // = $_SESION['username'];

            //kung naka session ang username largo nalang diri....
            $model = new Model();
            $result = $model->getUserByUsername($username);
            if(count($result) > 0){
                foreach($result as $res){
                    $data [] = $res;
                }
                $return ['msg'] = $data;
                $return ['error']= false;
            }
            else{
                $return ['msg'] = 'No data found';
                $return ['error'] = true;
            }
    }
    //tangtanga lang nya ni kung ma session na angg username...
    else{
            $return ['msg'] = 'Something went wrong';
            $return ['error'] = true;
    }//kutob diri..
}
else{
    $return ['msg'] = 'Invalid Request';
    $return ['error'] = true;
}

echo json_encode($return);



?>
