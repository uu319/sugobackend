<?php

require_once __DIR__ . '/notification.php';
$notification = new Notification();

$return = array();

if(isset($_POST['title']) && isset($_POST['message']) && isset($_POST['image']) &&
    isset($_POST['action']) && isset($_POST['destination']) && isset($_POST['body']) &&
    isset($_POST['text']) && isset($_POST['click_action']) && isset($_POST['token'])){

      //data
      $notification->setTitle($_POST['title']);
      $notification->setMessage($_POST['message']);
      $notification->setImage($_POST['image']);
      $notification->setAction($_POST['action']);
      $notification->setActionDestination($_POST['destination']);
      //notification
      $notification->setBody($_POST['body']);
      $notification->setText($_POST['text']);
      $notification->setClickAction($_POST['click_action']);

      $requestData = $notification->getDataPayload();
      $requestNotification= $notification->getNotification();
      $fields = array(
        'to' => $_POST['token'],
        'data' => $requestData,
        'notification'=>$requestNotification,
      );
      $notification->setFields($fields);
      $notification->notifHandler();
      $return['token']=$requestData;
      $return['fields']= $fields;

      echo json_encode($fields);
}else{
  echo "invalid request";
}
//
// public class MyFirebaseMessagingService extends FirebaseMessagingService {
// @Override
// public void onMessageReceived(RemoteMessage remoteMessage) {
//     super.onMessageReceived(remoteMessage);
//     Log.d("msg", "onMessageReceived: " + remoteMessage.getData().get("message"));
//         Intent intent = new Intent(this, MainActivity.class);
//         intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
//         PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent, PendingIntent.FLAG_ONE_SHOT);
//         String channelId = "Default";
//         NotificationCompat.Builder builder = new  NotificationCompat.Builder(this, channelId)
//                 .setSmallIcon(R.mipmap.ic_launcher)
//                 .setContentTitle(remoteMessage.getNotification().getTitle())
//                 .setContentText(remoteMessage.getNotification().getBody()).setAutoCancel(true).setContentIntent(pendingIntent);;
//         NotificationManager manager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
//         if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
//             NotificationChannel channel = new NotificationChannel(channelId, "Default channel", NotificationManager.IMPORTANCE_DEFAULT);
//             manager.createNotificationChannel(channel);
//         }
//         manager.notify(0, builder.build());
// }
//
// }





?>
