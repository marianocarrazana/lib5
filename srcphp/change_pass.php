  <?php
    session_start();
    include('acceso_db.php'); // incluímos los datos de conexión a la BD
    if(isset($_SESSION['user_name'])) { // comprobamos que la sesión esté iniciada
        if(isset($_POST['send'])) {
            if($_POST['user_pass'] != $_POST['user_pass_conf']) {
                echo "Las contraseñas ingresadas no coinciden. <a href='javascript:history.back();'>Reintentar</a>";
            }else {
                $user_name = $_SESSION['user_name'];
                $user_pass = $mysqli->real_escape_string($_POST["user_pass"]);
                $user_pass = md5($user_pass); // encriptamos la nueva contraseña con md5
                $sql = $mysqli->query("UPDATE users SET user_pass='".$user_pass."' WHERE user_name='".$user_name."'");
                if($sql) {
                    echo "Contraseña cambiada correctamente.";
                }else {
                    echo "Error: No se pudo cambiar la contraseña. <a href='javascript:history.back();'>Reintentar</a>";
                }
            }
        }else {
?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label>Nueva contraseña:</label><br />
            <input type="password" name="user_pass" maxlength="15" /><br />
            <label>Confirmar:</label><br />
            <input type="password" name="user_pass_conf" maxlength="15" /><br />
            <input type="submit" name="send" value="Enviar" />
        </form>
<?php
        }
    }else {
        echo "Acceso denegado.";
    }
?> 