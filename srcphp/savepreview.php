<?php 
session_start();
if ( isset($_POST["image"]) && !empty($_POST["image"]) ) {    
    $dataURL = $_POST["image"];  
    $parts = explode(',', $dataURL);  
    $data = $parts[1];  
    $data = base64_decode($data);  
    $fp = fopen("../".$_POST["name"].'.png', 'w');  
    fwrite($fp, $data);  
    fclose($fp); 
}
else{
if (empty($_FILES) || $_FILES["file"]["error"]) {
  die('{"OK": 0}');
}
 
$fileName = $_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"], "../users/".$_SESSION['user_name'].".png");
 
die('{"OK": 1}');
}
?> 
