<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('access_db.php');include('escape.php');
if(empty($_SESSION['user_name'])){die("['Usuario no registrado. ']");}
if(isset($_POST["subject"]))
{
$subject = escape($_POST['subject']);
$sql = $mysqli->query("SELECT sub_title FROM subjects WHERE sub_title='".$subject."'");
        if($sql->num_rows > 0) 
        {
        }
        else
        {
            $reg = $mysqli->query("INSERT INTO subjects (sub_title) VALUES ('".$subject."')");
            if($reg) 
            {
            }
            else 
            {
                echo "ha ocurrido un error y no se registro la materia.";
            }
    }
}else{die("No hay materia.");}
if(isset($_POST["book_title"]))
{
$book_link = "libros/".$_REQUEST['book_dir']."/";
$target_dir = "../". $book_link;
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$book_link = $book_link . safeName($_REQUEST['name']);

require_once("plupload.php");
PluploadHandler::no_cache_headers();
PluploadHandler::cors_headers();
if (!PluploadHandler::handle(array(
	'target_dir' => $target_dir,
	'allow_extensions' => 'pdf',
))) {
	die(json_encode(array(
		'OK' => 0, 
		'error' => array(
			'code' => PluploadHandler::get_error_code(),
			'message' => PluploadHandler::get_error_message()
		)
	)));
} else {
	echo json_encode(array('OK' => 1));
	$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
	$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
	if (!$chunks || $chunk == $chunks - 1) {
	$book_title = escape($_POST['book_title']);
		$book_size = escape($_POST['book_size']);
		echo json_encode(array('name' => $book_link));
		$reg = $mysqli->query("INSERT INTO books (book_title, book_subject, book_size, book_uploader,book_link,book_datereg) VALUES ('".$book_title."', '".$subject."', '".$book_size."','".$_SESSION['user_name']."','".$book_link."',  NOW())");
        if($reg) 
        {
           die(json_encode(array('Data' => 1)));
        }
	}
}

}
if(isset($_POST["video_link"]))
{
  $video_link = escape($_POST['video_link']);
  $video_title = escape($_POST['video_title']);
  if(strpos($video_link, 'http')===false){$video_link="http://".$video_link;}
  if(strpos($video_link, 'youtube')===false){echo "No es un video de youtube";exit();}
  
  $videoType = array("v/", "watch?v=");
  $video_link = str_replace($videoType, "embed/", $video_link);
  $video_link = str_replace("&list", "?list", $video_link);
  $reg = $mysqli->query("INSERT INTO videos (video_title, video_subject, video_link, video_uploader,video_datereg) VALUES ('".$video_title."','".$subject."', '".$video_link."','".$_SESSION['user_name']."',  NOW())");
        if($reg) 
        {
            header("Location: ../index.php?s=videos");
        }
        else 
        {
            echo "No se registraron datos<br>";
        }
}
if(isset($_POST["file_link"]))
{
  $file_link = escape($_POST['file_link']);
  $file_link = str_replace(array("\r\n", "\r", "\n",'\r\n'),"<br>",$file_link);
  $file_title = escape($_POST["file_title"]);
  $reg = $mysqli->query("INSERT INTO files (file_subject,file_title, file_link, file_uploader,file_datereg) VALUES ('".$subject."', '".$file_title."', '".$file_link."','".$_SESSION['user_name']."',  NOW())");
        if($reg) 
        {
            header("Location: ../index.php?s=archivos");
        }
        else 
        {
            echo "No se registraron datos<br>";
        }
}
if(isset($_POST["app_web"]))
{
  $app_title = escape($_POST['app_title']);
  $app_web = escape($_POST['app_web']);
  if(strpos($app_web, 'http')===false){$app_web="http://".$app_web;}

  $app_windows = escape($_POST['app_windows']);
  if(strpos($app_windows, 'http')===false && $app_windows!=""){$app_windows="http://".$app_windows;}

  $app_linux = escape($_POST['app_linux']);
  if(strpos($app_linux, 'http')===false && $app_linux!=""){$app_linux="http://".$app_linux;}

  $app_android = escape($_POST['app_android']);
  if(strpos($app_android, 'http')===false && $app_android!=""){$app_android="http://".$app_android;}

  $app_ios = escape($_POST['app_ios']);
  if(strpos($app_ios, 'http')===false && $app_ios!=""){$app_ios="http://".$app_ios;}
  echo $app_web ."<br>". $app_windows ."<br>". $app_ios;
  
  $reg = $mysqli->query("INSERT INTO apps (app_title,app_subject, app_web, app_windows, app_linux, app_android, app_ios, app_uploader,app_datereg) VALUES ('".$app_title."','".$subject."', '".$app_web."','".$app_windows."','".$app_linux."','".$app_android."','".$app_ios."','".$_SESSION['user_name']."',  NOW())");
        if($reg) 
        {
            echo("Location: ../index.php?s=apps");
        }
        else 
        {
            echo "No se registraron datos<br>";
        }
}
function safeName($filename)
{
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
	    $filename = str_replace($special_chars, '', $filename);
	    $filename = preg_replace('/[\s-]+/', '-', $filename);
	    $filename = trim($filename, '.-_');
	    return $filename;
}
?>