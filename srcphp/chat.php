<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include('access_db.php');
include('escape.php');
if(empty($_SESSION['user_name'])){echo 'No puedes acceder al chat';} 
else
{
  if($_POST['type']=="send")
  {
  $message = escape($_POST['msg']);
  if($message!=""){
  $string = "INSERT INTO chat (chat_message, chat_userid, chat_sendto, chat_sendtime) VALUES ('".$message."', '".$_SESSION['user_id']."', '".$_POST['sendto']."',  NOW())";
  $reg = $mysqli->query($string);
                if($reg) {echo "Ah sido registrado.";echo $message;}
                else {echo "ha ocurrido un error y no se registraron los datos.\nQuery:".$string;}
  }else{echo "Mensaje vacio";}
  }
  else if($_POST['type']=="get")
  {
	$chat = $mysqli->query("SELECT * FROM chat WHERE chat_sendto='global' ORDER BY chat_id DESC LIMIT 25");
	//$chat = $mysqli->query("SELECT * FROM chat WHERE chat_sendto=".$_SESSION['user_id']);
	$out = "[";
	while ($row = $chat->fetch_array()) 
	{
	$users = $mysqli->query("SELECT user_name FROM users WHERE user_id=".$row['chat_userid']);
	$row2 = $users->fetch_array();
	$message = $mysqli->real_escape_string($row['chat_message']);
	$out = $out.'{"to":"'.$row['chat_sendto'].'","msg":"'.$message.'","from":"'.$row2['user_name'].'","date":"'.$row['chat_sendtime'].'"},';
	}
	$out = substr($out, 0, -1);
	echo $out."]";
  }
  else{echo "Tipo incorrecto.";}
}
?>