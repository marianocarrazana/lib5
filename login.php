<?php session_start(); ?>
<html>
<head>
<title>uTux-Login</title>
<meta charset="utf-8" />
<script src="src/base.js"></script>
<script src="src/language.js"></script>
<script src="src/login.js"></script>
<link rel="stylesheet" type="text/css" href="sty/login.css" />
<link rel="stylesheet" type="text/css" href="sty/base.css" />
<link href='http://fonts.googleapis.com/css?family=Averia+Sans+Libre' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="container-login" class="big-container">
<div id="logo-container">
<img id="logo-img" src="img/utux-logo.png" width="612" height="412" alt="uTux Login"/>
</div>
<?php
    if($_GET["ur"]!=""&&!empty($_SESSION['user_name'])){
    echo "<script>window.location='install_app.html?ur=".$_GET["ur"]."&extra=".base64_encode($_GET["extra"])."';</script>";
    }
    if($_GET["extra"]!=""){$out=$_GET["ur"]."&extra=".$_GET["extra"];}
    if(empty($_SESSION['user_name'])) {
    echo '<form id="log" action="srcphp/check.php?ur='.$out.'" method="post">'
    ?>
    
            <label>Usuario</label><br />
            <input type="text" class="utux-text-input" name="user_name" /><br />
            <label>Contraseña</label><br />
            <input type="password" class="utux-text-input" name="user_pass" /><br />
            <input type="submit" class="utux-btn" name="send" value="Ingresar" style="background-color:orange" />
        </form>
<?php
    }else {
?>
        <p>Hola <strong><?=$_SESSION['user_name']?></strong> | <a href="srcphp/logout.php">Salir</a></p>
<?php
    }
		 if(empty($_SESSION['user_name'])) {
			echo '<form id="reg" action="srcphp/reg_user.php?ur='.$out.'" method="post">'
?>
        <label>Usuario</label><br />
        <input type="text" class="utux-text-input" name="user_name" maxlength="15" /><br />
        <label>Contraseña</label><br />
        <input type="password" class="utux-text-input" name="user_pass" maxlength="15" /><br />
        <label>Confirmar Contraseña</label><br />
        <input type="password" class="utux-text-input" name="user_pass_conf" maxlength="15" /><br />
        <label>Email</label><br />
        <input type="text" class="utux-text-input" name="user_mail" maxlength="50" /><br />
        <input type="submit" class="utux-btn" name="send" value="Registrar" style="background-color:orange" />
    </form>
    <button onclick="showReg()" id="reg-btn" class="utux-btn" style="background-color:green"><script>document.write(langReg)</script></button>
<?php
    }
?> 
</div>
</body>
</html>