<?php
    session_start();
    include('access_db.php');
    $perfil = $mysqli->query("SELECT * FROM users WHERE user_id='".$_GET['id']."'") or die($mysqli->error());
    if($perfil->num_rows) { // Comprobamos que exista el registro con la ID ingresada
        $row = $mysqli->fetch_array($perfil);
        $id = $row["user_id"];
        $nick = $row["user_name"];
        $email = $row["user_mail"];
        $freg = $row["user_datereg"];
?>
        <strong>Nick:</strong> <?=$nick?><br />
        <strong>Email:</strong> <?=$email?><br />
        <strong>Registrado el:</strong> <?=$freg?><br />
        <strong>URL del perfil:</strong> <a href="perfil.php?id=<?=$id?>">Click aquí</a>
<?php
    }else {
?>
        <p>El perfil seleccionado no existe o ha sido eliminado.</p>
<?php
    }
?> 