<?php session_start();include('srcphp/access_db.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<title>Chat</title>
<link rel="icon" type="image/png" href="favicon.png" />
<script src="src/jquery-2.1.0.min.js"></script>
<script src="src/moment.js"></script>
<script src="src/moment-timezone.js"></script>
<script src="src/typeahead.js"></script>
<script src="src/base.js"></script>
<script src="src/loadchat.js"></script>
<script src="build/pdf.js"></script>
<script src="build/pdf.worker.js"></script>
<script src="src/linx-ui-web.js"></script>
<link rel="stylesheet" type="text/css" href="styles/base.css" />
<link rel="stylesheet" type="text/css" href="styles/chat.css" />
</head>
<body class="color2">
<?php
    if(!empty($_SESSION['user_name'])) {
?>
<script>isLogin=true;myName=<?php echo '"'.$_SESSION['user_name'].'"'; ?></script>
<?php }; ?>

<header id="bigContainer"></header>
<header class="color1" style="display:none">
</header>
<script type="text/javascript">
var homeDiv="";
</script>
</body>
</html>
