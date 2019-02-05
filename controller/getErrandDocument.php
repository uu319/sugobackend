<?php

require "../model/Model.php";

$return = array();

$model = new Model();
$result = $model->getErrandDocument();
if(count($result) > 0){
    foreach($result as $res){
        $data [] = $res;
        $req = explode(",", $res['document_requirement']);

        $req2 [] = array('errand_document_id'=>$res['errand_document_id'], 'errand_document'=>$res['errand_document'], 'document_requirement'=>$req, 'errand_category_id'=>$res['errand_category_id']);
    }
    
    $return ['msg'] = $req2;
    $return ['error'] = false;
}
else{
    $return ['msg'] = 'No errand document yet';
    $return ['error'] = true;
}

echo json_encode($return);



?>