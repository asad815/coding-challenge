<?php 
session_start();
include_once('Database.php');  
if(isset($_FILES['json_file'])){
    $ext = pathinfo($_FILES['json_file']['name'], PATHINFO_EXTENSION);
    if($ext == 'json'){
        $json_raw_string = file_get_contents($_FILES['json_file']['tmp_name']);
        if ($json_raw_string === false) {
            $_SESSION['error'] = 'No content found';
        }    

        $json_array = json_decode($json_raw_string,true);
        if ($json_array=== null) {
            $_SESSION['error'] = 'File dosenot contain any json string';
        }

       
        $mysql_obj->insert_rows($json_array);
        $_SESSION['success'] = 'File has been uploaded successfully';

    }else{
        $_SESSION['error'] = 'Invalid file type';
    }
   

    header('Location: /coding-challange/');
    print_r($json_array);
    exit;
}  
?>