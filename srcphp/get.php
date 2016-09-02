<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('access_db.php');
if(empty($_SESSION['user_name'])){die("['Usuario no registrado']");}
if(!empty($_POST['type'])){
if($_POST['type']=='books')
{
  $books = $mysqli->query("SELECT * FROM books ORDER BY book_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  $out = "[";
  while ($row = $books->fetch_array()) 
  {
	$out = $out.outBook($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='subjects')
{
  $subjects = $mysqli->query("SELECT * FROM subjects ORDER BY sub_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  $out = "[";
  while ($row = $subjects->fetch_array()) 
  {
	$out = $out.'{"title":"'.$row['sub_title'].'","teachers":"'.$row['sub_teachers'].'","time":"'.$row['sub_time'].'"},';
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='subjectSelect')
{
  $out = "[";
  $books = $mysqli->query("SELECT * FROM books WHERE book_subject='".$_POST['subject']."' ORDER BY book_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $books->fetch_array()) 
  {
  $out = $out.outBook($row);
  }
  $apps = $mysqli->query("SELECT * FROM apps WHERE app_subject='".$_POST['subject']."' ORDER BY app_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $apps->fetch_array($apps)) 
  {
  $out = $out.outApp($row);
  }
  $files = $mysqli->query("SELECT * FROM files WHERE file_subject='".$_POST['subject']."' ORDER BY file_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $files->fetch_array()) 
  {
  $out = $out.outFile($row);
  }
  $videos = $mysqli->query("SELECT * FROM videos WHERE video_subject='".$_POST['subject']."' ORDER BY video_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $videos->fetch_array()) 
  {
  $out = $out.outVideo($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='search')
{
  $out = "[";
  $books = $mysqli->query("SELECT * FROM books WHERE book_subject LIKE '%".$_POST['search']."%' OR book_title LIKE '%".$_POST['search']."%' ORDER BY book_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $books->fetch_array()) 
  {
  $out = $out.outBook($row);
  }
  $apps = $mysqli->query("SELECT * FROM apps WHERE app_subject LIKE '%".$_POST['search']."%' OR app_title LIKE '%".$_POST['search']."%' ORDER BY app_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $apps->fetch_array()) 
  {
  $out = $out.outApp($row);
  }
  $files = $mysqli->query("SELECT * FROM files WHERE file_subject LIKE '%".$_POST['search']."%' OR file_title LIKE '%".$_POST['search']."%' ORDER BY file_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $files->fetch_array()) 
  {
  $out = $out.outFile($row);
  }
  $videos = $mysqli->query("SELECT * FROM videos WHERE video_subject LIKE '%".$_POST['search']."%' OR video_title LIKE '%".$_POST['search']."%' ORDER BY video_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  while ($row = $videos->fetch_array()) 
  {
  $out = $out.outVideo($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='videos')
{
  $videos = $mysqli->query("SELECT * FROM videos ORDER BY video_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  $out = "[";
  while ($row = $videos->fetch_array()) 
  {
  $out = $out.outVideo($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='apps')
{
  $apps = $mysqli->query("SELECT * FROM apps ORDER BY app_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  $out = "[";
  while ($row = $apps->fetch_array()) 
  {
  $out = $out.outApp($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_POST['type']=='files')
{
  $files = $mysqli->query("SELECT * FROM files ORDER BY file_id DESC LIMIT ".$_POST['limit']." OFFSET ".$_POST['offset']);
  $out = "[";
  while ($row = $files->fetch_array()) 
  {
  $out = $out.outFile($row);
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
}
if(!empty($_GET['type'])){
if($_GET['type']=='books')
{
  $books = $mysqli->query("SELECT * FROM books ");
  $out = "[";
  while ($row = $books->fetch_array()) 
  {
	$out = $out.'"'.$row['book_title'].'",';
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
else if($_GET['type']=='subjects')
{
  $subjects = $mysqli->query("SELECT * FROM subjects");
  $out = "[";
  while ($row = $subjects->fetch_array()) 
  {
	$out = $out.'"'.$row['sub_title'].'",';
  }
  $out = substr($out, 0, -1);
  echo $out."]";
}
}
function outVideo($row)
{
  return '{"type":"video","id":"'.$row["video_id"].'","title":"'.$row["video_title"].'","link":"'.$row['video_link'].'","uploader":"'.$row['video_uploader'].'","subject":"'.$row['video_subject'].'"},';
}
function outBook($row)
{
  return '{"type":"book","id":"'.$row['book_id'].'","uploader":"'.$row['book_uploader'].'","link":"'.$row['book_link'].'","title":"'.$row['book_title'].'","subject":"'.$row['book_subject'].'","size":"'.$row['book_size'].'"},';
}
function outApp($row)
{
  return '{"type":"app","id":"'.$row["app_id"].'","ios":"'.$row['app_ios'].'","linux":"'.$row['app_linux'].'","windows":"'.$row['app_windows'].'","android":"'.$row['app_android'].'","web":"'.$row['app_web'].'","title":"'.$row['app_title'].'","subject":"'.$row['app_subject'].'","uploader":"'.$row['app_uploader'].'"},';
}
function outFile($row)
{
  return '{"type":"file","id":"'.$row['file_id'].'","title":"'.$row['file_title'].'","link":"'.$row['file_link'].'","uploader":"'.$row['file_uploader'].'","subject":"'.$row['file_subject'].'"},';
}
?>