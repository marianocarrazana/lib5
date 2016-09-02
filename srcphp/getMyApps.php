<?php 
session_start();
header('Content-Type: text/html; charset=utf-8');
include('access_db.php');
 if(empty($_SESSION['user_name'])){echo 'Not Apps';}
 else
 {
	$result = $mysqli->query("SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] . "'");
	$row = $result->fetch_array($result);
	parse_str($row["user_apps"]);
	$n=count($myApps);
	echo "[";
	for($i=0;$i<$n;$i++)
	{
		$file = str_replace('﻿','',file_get_contents($myApps[$i]));
		$js = json_decode($file);
		if($js!=null){
		echo $file;}
		else{
		echo '{"name":"App-Offline","icons":{"64": "http://utux.com.ar/img/offline.png"}}';
		}
		echo ',';
		echo '"' . domain($myApps[$i]) . '"';
		echo ',';
		echo '"' . $myApps[$i] . '"';
		if($i+1!=$n){echo ",";}
	}
	echo "]";
 }
function clean($str)
{
    $convmap = array(0x80, 0x10ffff, 0, 0xffffff);
    return preg_replace('/\x{EF}\x{BF}\x{BD}/u', '', mb_encode_numericentity($str, $convmap, "UTF-8"));
}
function domain($url)
{
	$parse = parse_url($url);
	return $parse['scheme'] . "://" . $parse['host'];
}
?>