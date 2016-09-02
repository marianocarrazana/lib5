<?php 
session_start();
include('access_db.php');
 if(empty($_SESSION['user_name'])){echo 'Update error';}
 else
 {
	$v="UPDATE users SET user_apps='" . $_POST["apps"] . "' WHERE user_name='" . $_SESSION['user_name'] . "'";
	$mysqli->query($v);
?>
<html>
<head>
<script>
window.location="../start.php"
</script>
</head>
<body>
<p>App installed,now yo will redirect</p>
</body>
</html>
<?php
 }
?>