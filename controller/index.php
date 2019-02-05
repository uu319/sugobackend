<?php
if(isset($_POST['title'])){

  require_once __DIR__ . '/notification.php';
  $notification = new Notification();

  $title = $_POST['title'];
  $message = isset($_POST['message'])?$_POST['message']:'';
  $imageUrl = isset($_POST['image_url'])?$_POST['image_url']:'';
  $action = isset($_POST['action'])?$_POST['action']:'';

  $text = $_POST['text'];
  $body = $_POST['body'];

  $click_action = $_POST['click_action'];


  $actionDestination = isset($_POST['action_destination'])?$_POST['action_destination']:'';

  if($actionDestination ==''){
    $action = '';
  }
  $notification->setTitle($title);
  $notification->setMessage($message);
  $notification->setImage($imageUrl);
  $notification->setAction($action);
  $notification->setActionDestination($actionDestination);

  $notification->setBody($body);
  $notification->setText($text);
  $notification->setClickAction($click_action);

  $firebase_token = $_POST['firebase_token'];


  $topic = $_POST['topic'];

  $requestData = $notification->getDataPayload();
  $requestNotification= $notification->getNotification();

  // if($_POST['send_to']=='topic'){
  //   $fields = array(
  //     'to' => '/topics/' . $topic,
  //     'data' => $requestData,
  //   );

  // }else{

    $fields = array(
      'to' => $firebase_token,
      'data' => $requestData,
      'notification'=>$requestNotification,
    );
      $notification->setFields($fields);
      $notification->notifHandler();

  // }


  // Set POST variables
  // $url = 'https://fcm.googleapis.com/fcm/send';
  //
  // $headers = array(
  //   'Authorization: key=' . $firebase_api,
  //   'Content-Type: application/json'
  // );


}else{
  echo "Invalid Request";
}
?>
