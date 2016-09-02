<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include('access_db.php');
include('escape.php');
 if(empty($_SESSION['user_name'])){echo 'Registrese';}
 else
 {
 	$id=escape($_POST["id"]);
 	$type=escape($_POST["type"]);
 	if($type=="book")
	{
		if($_SESSION['user_type']=="def"){$sql = "SELECT * FROM books WHERE ".$type."_id=".$id." AND ".$type."_uploader='".$_SESSION['user_name']."'";}
		else if($_SESSION['user_type']=="mod" || $_SESSION['user_type']=="dev"){$sql = "SELECT * FROM books WHERE ".$type."_id=".$id;}
		$result = $mysqli->query($sql);
		while ($row = $result->fetch_array()) 
		{
			unlink(realpath("../".$row["book_link"]));
			unlink(realpath("../".$row["book_link"].".png"));
		}

	}
 	if($_SESSION['user_type']=="def"){$sql = "DELETE FROM ".$type."s WHERE ".$type."_id=".$id." AND ".$type."_uploader='".$_SESSION['user_name']."'";}
 	else if($_SESSION['user_type']=="mod" || $_SESSION['user_type']=="dev"){$sql = "DELETE FROM ".$type."s WHERE ".$type."_id=".$id;}
	$result = $mysqli->query($sql);
	
 }

?>