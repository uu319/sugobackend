<?php

require "../model/Model.php";

date_default_timezone_set('Asia/Manila');

$return = array();
$option_id = "";
$description = "";
$eseekerUsername = "";
$location = "";


$bookingFee = 0;
$ratePerHour = 0;

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['option_id']) &&
        isset($_POST['description']) &&
        isset($_POST['eseeker_username']) &&
        isset($_POST['location'])){

            $eseekerUsername = $_POST['eseeker_username'];
            $erunnerUsername = "";
            $option_id = $_POST['option_id'];
            $location = $_POST['location'];

            $date_published = date('Y-m-d H:i:s');
            $date_start = '0000-00-00 00:00:00';
            $date_end = '0000-00-00 00:00:00';
            $status = 'pending';
            $description = $_POST['description'];
            $totalFee = 0;
            $rating = "";
            $feedback = "";

            $md = new Model();
            $fee = $md->getPaymentDetails($option_id);
            if(count($fee) > 0){
                foreach ($fee as $f) {
                    $bookingFee = $f['booking_fee'];
                    $ratePerHour = $f['rate_per_hour'];
                }
                $return ['msg'] = array($bookingFee, $ratePerHour);
                $return ['error'] = false;
            }



            $model = new Model();
            $errandCategory = $model->getErrandCategoryByErrandOption($option_id);
            if($errandCategory[0]['errand_name'] == "CLAIMING / FILING DOCUMENTS"){
              $description = "Please get me a ".$errandCategory[0]['option_name']." document., No additional description.";
            }
            else if($errandCategory[0]['errand_name'] == "BILLS PAYMENT"){
              $description = "Please pay my ".$errandCategory[0]['option_name']." bill for me., No additional description.";
            }
            else{
              $description;
            }
            $result = $model->postErrand($eseekerUsername, $erunnerUsername, $option_id, $location, $date_published, $date_start, $date_end, $status, $description, $totalFee, $bookingFee, $ratePerHour, $rating, $feedback);
            if($result){
                $return ['msg'] = 'Errand successfully posted';
                $return ['error'] = false;
                $return['errand_id']= $result;
            }
            else{
                $return ['msg'] = 'Failed to post errand';
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
//
// if($return['error']==false){
//   include "getMatchErunner.php";
//   $match= getMatchErunner($result);
// }
//



?>
