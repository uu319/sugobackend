<?php

require "../model/Model.php";

$return = array();
// $data = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['errand_id']) &&
        isset($_POST['type'])  &&
        isset($_POST['username'])){


        $model = new Model();
        $result = $model->getUserErrandsByErrandId($_POST['errand_id']);
        if(count($result) > 0){
            foreach($result as $res){
                $data[] = $res;
                $description = $res['description'];
                $option_id = $res['option_id'];
            }
            if($option_id == 17){
              $desc = explode(',', $description);
              $desc1 = "I'm looking for $desc[1] $desc[2] of $desc[0]. My budget is $desc[3]. Just message me if you need more information.";
              $desc2 = $desc[4];

            }
            else if($option_id == 19){
              $desc = explode(',', $description);
              $desc1 = "I'm looking for a $desc[0] service within $desc[1]. My budget is $desc[2]. Just message me if you need more information.";
              $desc2 = $desc[3];
            }
            else if($option_id == 21){
              $desc = explode(',', $description);
              $desc1 = "I'm looking for a $desc[0]. Good for $desc[1] person. My budget is Php$desc[2]. Just message me if you need more information.";
              $desc2 = $desc[3];
            }
            else{
              $desc = explode(',', $description);
              $desc1 = $desc[0];
              $desc2 = $desc[1];
            }
            foreach($data as $errand){
                if($_POST['type'] == 'erunner'){
                    $username = $errand['eseeker_username'];
                }
                else{
                    $username = $errand['erunner_username'];
                }
            }

            $userInfo = $model->getUserByUsername($username);
            if(!empty($userInfo)){
                foreach($userInfo as $info){
                    $user [] = $info;
                }
                $errandDetails = array_merge($data, $user);
            }
            else {
              $errandDetails = array_merge($data);
            }



            if($_POST['type'] == 'erunner'){
                $return ['msg'] = $errandDetails;
            }
            else{
                $return ['msg'] = $errandDetails;

            }

            // $return ['msg'] = $data;
            $return['description'] = $desc1;
            $return['additional_description'] = $desc2;
            $return ['error'] = false;
        }
        else{
            $return ['msg'] = 'No errand';
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
