<?php 
session_start();
include_once('Database.php'); 
    if(isset($_POST['employee_name']) or isset($_POST['event_name']) or isset($_POST['event_date'])){
        //Search Function Call
        $result = $mysql_obj->search($_POST);
        if(count($result) > 0){
            http_response_code(200);
            exit(json_encode(['rows' => $result, 'status_code' => 200]));
        }else{
            http_response_code(404);
            exit(json_encode(['msg' => 'Record Not Found!']));
        }
    }else{
        http_response_code(400);
        exit(json_encode(['msg' => 'Bad Request!']));
    }

?>