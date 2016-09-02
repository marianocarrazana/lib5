<?php
function escape($text)
{
	global $mysqli;
	$text = $mysqli->real_escape_string($text);
  	$text = trim($text);
  	$text = strip_tags($text);
  	$text = str_replace("'","\"",$text);
  	$text = str_replace('"','\"',$text);
  	$invalid = array("-Windows-", "-Linux(desktop)-", "-Android-", "-iOS-");
 	$text = str_replace($invalid, "", $text);
	return $text;
}
?>