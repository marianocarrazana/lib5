<?php
    include('access_db.php'); // incluímos los datos de acceso a la BD
    if(isset($_POST['send'])) { // comprobamos que se han enviado los datos del formulario
        if(empty($_POST['user_name'])) {
            echo "No ha ingresado el usuario. <a href='javascript:history.back();'>Reintentar</a>";
        }else {
            $user_name = mysql_real_escape_string($_POST['user_name']);
            $user_name = trim($user_name);
            $sql = mysql_query("SELECT user_name, user_pass, user_mail FROM users WHERE user_name='".$user_name."'");
            if(mysql_num_rows($sql)) {
                $row = mysql_fetch_assoc($sql);
                $num_caracteres = "10"; // asignamos el número de caracteres que va a tener la nueva contraseña
                $nueva_clave = substr(md5(rand()),0,$num_caracteres); // generamos una nueva contraseña de forma aleatoria
                $user_name = $row['user_name'];
                $user_pass = $nueva_clave; // la nueva contraseña que se sendá por correo al usuario
                $user_pass2 = md5($user_pass); // encriptamos la nueva contraseña para guardarla en la BD
                $user_mail = $row['user_mail'];
                // actualizamos los datos (contraseña) del usuario que solicitó su contraseña
                mysql_query("UPDATE users SET user_pass='".$user_pass2."' WHERE user_name='".$user_name."'");
                // Enviamos por email la nueva contraseña
                $remite_nombre = ""; // Tu nombre o el de tu página
                $remite_email = ""; // tu correo
                $asunto = "Recuperación de contraseña"; // Asunto (se puede cambiar)
                $mensaje = "Se ha generado una nueva contraseña para el usuario <strong>".$user_name."</strong>. La nueva contraseña es: <strong>".$user_pass."</strong>.";
                $cabeceras = "From: ".$remite_nombre." <".$remite_email.">\r\n";
                $cabeceras = $cabeceras."Mime-Version: 1.0\n";
                $cabeceras = $cabeceras."Content-Type: text/html";
                $send_email = mail($user_mail,$asunto,$mensaje,$cabeceras);
                if($send_email) {
                    echo "La nueva contraseña ha sido enviada al email asociado al usuario ".$user_name.".";
                }else {
                    echo "No se ha podido send el email. <a href='javascript:history.back();'>Reintentar</a>";
                }
            }else {
                echo "El usuario <strong>".$user_name."</strong> no está registrado. <a href='javascript:history.back();'>Reintentar</a>";
            }
        }
    }else {
?>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <label>Usuario:</label><br />
        <input type="text" name="user_name" /><br />
        <input type="submit" name="send" value="Enviar" />
    </form>
<?php
    }
?> 