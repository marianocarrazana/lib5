<?php 
session_start();
include('access_db.php');
if(empty($_SESSION['user_name'])){echo 'You are not logged';}
else
{
	$sql = mysql_query("SELECT * FROM users WHERE user_name='".$_SESSION["user_name"]."'");
	$row = mysql_fetch_array($sql);
	$pos = strpos($row["allow_install"], $_GET["ur"]);
	if ($pos === false) {
	$manifest=$row["allow_install"] . "allow[]=" . $_GET["ur"] . "&";
	$v="UPDATE users SET allow_install='" . $manifest . "' WHERE user_name='" . $_SESSION['user_name'] . "'";
	mysql_query($v);
	}
	header("Location: app_log.php?ur=".$_GET['ur']."&extra=".$_GET["extra"]);
}
?>