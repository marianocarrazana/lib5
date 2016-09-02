<?php session_start();include('srcphp/access_db.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<title>Lib5</title>
<link rel="icon" type="image/png" href="favicon.png" />
<script src="src/jquery-2.1.0.min.js"></script>
<!-- <script src="src/jquery.form.js"></script> -->
<script src="src/moment.min.js"></script>
<script src="src/moment-timezone.js"></script>
<script src="src/typeahead.js"></script>
<script src="src/base.js"></script>
<script src="src/loadhome.js"></script>
<script src="build/pdf.js"></script>
<script src="build/pdf.worker.js"></script>
<script src="src/linx-ui-web.js"></script>
<script src="plupload/plupload.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="styles/base.css" />
</head>
<body class="color2">
<noscript><table><tr><td>Active Javascript para usar esta pagina</td></tr></table></noscript>
<img src="img/menu.png" alt="menu" id="menu" onclick="showMenu(this)">
<header class="color1">
<div class="color2" id="search"><img src="img/search.png" /><input onchange="search(this.value,0,10)" class="typeahead" type="text" placeholder="Buscar"/></div>
<div class="align-right">
<?php
    if(empty($_SESSION['user_name'])) {
      $isLogin=false;
    ?>
<div class="category" onclick="showReg('login')"><span>Ingresar</span><img src="img/login.png"></div>
<div class="category" onclick="showReg('reg')"><span>Registrarse</span><img src="img/signin.png"></div>
</div>
<div id="container-login" class="color1" style="display:none">
<form id="log" action="srcphp/check.php" method="post" >
            <input type="text" placeholder="usuario" class="text-input" name="user_name" /><br />
            <input type="password" placeholder="contraseña" class="text-input" name="user_pass" /><br />
            <input type="submit" class="btn color3" name="send" value="Ingresar"  />
        </form>

        <form id="reg" action="srcphp/reg_user.php" method="post" >
        <input type="text" placeholder="usuario" class="text-input" name="user_name" maxlength="16" /><br />
        <input type="password" placeholder="contraseña" class="text-input" name="user_pass" maxlength="15" /><br />
        <input type="password" placeholder="confirmar contraseña" class="text-input" name="user_pass_conf" maxlength="15" /><br />
        <input type="text" placeholder="email" class="text-input" name="user_mail" maxlength="50" /><br />
        <label>Clave de registro<div class="info" onclick="displayMsg('Pida la clave de registro a un usuario ya registrado.')">?</div></label><br />
        <input type="text" placeholder="clave" class="text-input" name="reg" maxlength="16" /><br />
        <input type="submit" class="btn color3" name="send" value="Registrarse"  />
    </form>
<?php
    }else { $isLogin=true;
?>
   <table id="user"><tr><td id="avatar" onclick="displayMsg(avatarDiv);setTimeout(uploadAvatar,500)">
   <img <?php echo 'src="users/'.$_SESSION['user_name'].'.png"'; ?> onerror='this.src="img/avatar.png"' />
   </td><td id="user_name"><div><?=$_SESSION['user_name']?></div></td><td onclick="logout()" id="logout"><div></div></td></tr></table>
   <script>isLogin=true;
   const myName=<?php echo '"'.$_SESSION['user_name'].'";'; ?>
   const myType=<?php echo '"'.$_SESSION['user_type'].'";'; ?>
   const myPass=<?php echo '"'.$_SESSION['user_pass'].'";';  ?></script>
   <div class="category" onclick="getBooks(0,20)"><span>Libros</span><img src="img/libros.png"></div>
    <div class="category" onclick="getSubjects(0,20)"><span>Materias</span><img src="img/materias.png"></div>
    <div class="category" onclick="getApps(0,20)"><span>Apps</span><img src="img/apps.png"></div>
    <div class="category" onclick="getVideos(0,20)"><span>Videos</span><img src="img/videos.png"></div>
    <div class="category" onclick="getFiles(0,20)"><span>Archivos</span><img src="img/archivos.png"></div>
<?php
    }
?>
</div>

</header>
<script type="text/javascript">
const bu=isLogin?"Bienvenido "+myName+"!<br>Seleccione una categoría para empezar":"<span onclick=\"showReg('login')\">Ingrese</span> o <span onclick=\"showReg('red')\">registrese</span>";
const homeDiv="<table id='home' skip='true'><tr><td id='home1'>"+bu+"</td></tr></table>";
<?php
if($isLogin)
{
  ?>
var avatarDiv="<img id='avatarPreview' src=\"users/"+myName+".png\" onerror=\"this.src='img/avatar.png'\"/>\
				<a id=\"browse\" href=\"javascript:;\">Seleccionar imágen...</a>\
				<label>Nombre/s:</label><span contentEditable=true class='editable'></span><br>\
				<label>Apellido/s:</label><span contentEditable=true class='editable'></span><br>\
				<label>Sexo:</label><select><option value=''></option><option value='Hombre'>Hombre</option><option value='Mujer'>Mujer</option></select><br>\
				 <a id=\"start-upload\" class=\"btn color2\" href=\"javascript:;\">Actualizar datos</a>\
				 <div id=\"progressUp\"></div>";
  var bookDiv='<div colspan="columns" onclick="displayMsg(bookDiv2);setTimeout(uploadR,500)" class="color3 upButton" style="opacity:0">+ Agregar Libro</div>';
  var videoDiv='<div colspan="columns" onclick="displayMsg(videoDiv2)" class="color3 upButton" style="opacity:0">+ Agregar Video</div>';
  var fileDiv='<div colspan="columns" onclick="displayMsg(fileDiv2)" class="color3 upButton" style="opacity:0">+ Agregar Archivo</div>';
  var appDiv='<div colspan="columns" onclick="displayMsg(appDiv2)" class="color3 upButton" style="opacity:0">+ Agregar App</div>';
var bookDiv2='\
 <div id="uploadBook" colspan="columns" class="upload" ><div class="padding">\
 <form action="srcphp/upload.php" method="post" enctype="multipart/form-data">\
    <h2>Subir Libro</h2>\
    <a id="browse" href="javascript:;">Seleccionar archivo...</a><div id="filelist"></div>\
    <label>Título:</label><input type="text" class="text-input" id="book_title" maxlength="50" /><br/>\
    <label>Materia:</label><input type="text" class="typeahead" id="subject" maxlength="50" /><br/>\
    <a id="start-upload" class="btn color3" href="javascript:;">Subir Libro</a>\
</form>\
<div id="progressUp"></div>\
</div> </div>';
var videoDiv2='\
 <div id="uploadVideo" class="upload"><div class="padding">\
 <form action="srcphp/upload.php" method="post" enctype="multipart/form-data">\
    <h2>Agregar Video</h2>\
    <label>Título:</label><input type="text" class="text-input" name="video_title" id="video_title" ><br/>\
    <label>Link youtube:</label><input type="text" class="text-input" name="video_link" id="video_link" ><br/>\
    <label>Materia:</label><input type="text" class="typeahead" name="subject" maxlength="50" /><br/>\
    </select><br/>\
    <input type="submit" class="btn color3" value="Agregar Video" name="submit">\
</form>\
</div> </div>';
var fileDiv2='\
 <div id="uploadFile" class="upload"><div class="padding">\
 <form action="srcphp/upload.php" method="post" enctype="multipart/form-data">\
    <h2>Agregar Archivo(s)</h2>\
    <label>Link(s)[<a href="http://mega.co.nz" target="_blank">Mega</a>,<a href="http://mediafire.com" target="_blank">Mediafire</a>,<br><a href="http://drive.google.com" target="_blank">Google Drive</a>,etc.]:</label>\
    <textarea name="file_link" id="file_link" style="width:100%;height:50px;"></textarea>\
    <label>Nombre:</label><input type="text" class="text-input" name="file_title" maxlength="50" /><br/>\
    <label>Materia:</label><input type="text" class="typeahead" name="subject" maxlength="50" /><br/>\
    </select><br/>\
    <input type="submit" class="btn color3" value="Agregar Archivo(s)" name="submit">\
</form>\
</div> </div>';
var appDiv2='\
 <div id="uploadApp" class="upload" ><div class="padding">\
 <form action="srcphp/upload.php" method="post" enctype="multipart/form-data">\
    <h2>Agregar App</h2>\
    <label>Nombre:</label><input type="text" class="text-input" name="app_title" maxlength="50" /><br/>\
    <label>Materia:</label><input type="text" class="typeahead" name="subject" maxlength="50" /><br/>\
    <label>Webapp(link):</label><input type="text" class="text-input" name="app_web" /><br/>\
    <label>Links opcionales:</label><input value="-Windows-" onclick="this.value=\'\'" type="text" class="text-input" name="app_windows" /><br/>\
    <input value="-Linux(desktop)-" onclick="this.value=\'\'" type="text" class="text-input" name="app_linux" /><br/>\
    <input value="-Android-" onclick="this.value=\'\'" type="text" class="text-input" name="app_android" /><br/>\
    <input value="-iOS-" onclick="this.value=\'\'" type="text" class="text-input" name="app_ios" /><br/>\
    <input type="submit" class="btn color3" value="Agregar App" name="submit">\
</form>\
</div> </div>';
<?php
}
?>
</script>
<div id="loader">
<div id="loading-text">Cargando...</div>
<div id="loading-circles">
<script>
for(var i=0;i<8;i++)
 {
 var deg=i*(360/8);
 document.write("<circle id='circle"+i+"' style='transform:rotate("+deg+"deg);-webkit-transform:rotate("+deg+"deg);-moz-transform:rotate("+deg+"deg)'></circle>")
 }
</script>
</div></div>
<div id="bigContainer"></div>
<footer>Copyright Claudio Mariano Carrazana</footer>
</body>
</html>
