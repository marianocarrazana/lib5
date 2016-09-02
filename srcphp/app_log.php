<?php
session_start();
if(empty($_SESSION['user_name'])){echo 'error - Please login';}
else
{
include('access_db.php');
$extra=base64_decode($_GET["extra"]);
parse_str($extra);
if(empty($dev_id)){echo "error - The Developer ID is empty";}
else
{
	$sql = mysql_query("SELECT * FROM users WHERE dev_id='".$dev_id."'");
	if(!mysql_num_rows($sql)){echo "error - The Developer ID not exist";}
	else
	{
		$row = mysql_fetch_array($sql);
		$n = $row["dev_queries"];$n++;
		$v="UPDATE users SET dev_queries=" . $n . " WHERE dev_id='".$dev_id."'";
		mysql_query($v);
			$sql = mysql_query("SELECT * FROM users WHERE user_name='".$_SESSION["user_name"]."'");
			if(!mysql_num_rows($sql)){echo "error - The User not exist";}
			else
			{
				$row = mysql_fetch_array($sql);
				$pos = strpos($row["allow_install"], $_GET["ur"]);
				if ($pos === false) {echo "error - The URL is not allowed for this user";}
				else{
				if(empty($queries)){echo "error - The Queries is empty";}
				else
				{
				?>
<html>
<head>
<meta charset="utf-8" />
<script>
var message=<?php
					$n=count($queries);
					echo "{";
					for($i=0;$i<$n;$i++)
					{
						if($queries[$i]=="name"){echo '"name":"'.$row["user_name"].'"';}
						if($queries[$i]=="pass"){echo '"pass":"'.$row["utux_pass"].'"';}
						if($queries[$i]=="phone"){echo '"phone":"'.$row["user_phone"].'"';}
						if($queries[$i]=="mail"){echo '"mail":"'.$row["user_mail"].'"';}
						if($i+1!=$n){echo ",";}
					}
					echo "}";
				}
				?>;
parent.postMessage(message, "*");
</script>
</head>
</html>
				<?php
				if(!empty($manifest))
				{
					$pos = strpos($row["user_apps"], $manifest);
					if ($pos === false) {
					$manifest=$row["user_apps"] . '&myApps[]=' . $manifest;
					$v="UPDATE users SET user_apps='" . $manifest . "' WHERE user_name='" . $_SESSION['user_name'] . "'";
					mysql_query($v);
					}
				}
			}
		}
	}
 }
}
?>