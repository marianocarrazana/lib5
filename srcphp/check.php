<?php
    session_start();
    include('access_db.php');
    if(isset($_POST['send'])) {
        if(empty($_POST['user_name']) || empty($_POST['user_pass'])) {

            echo "El usuario o la contraseña no han sido ingresados. <a href='javascript:history.back();'>Reintentar</a>";
        }else {
            $user_name = $mysqli->real_escape_string($_POST['user_name']);
            $user_pass = $mysqli->real_escape_string($_POST['user_pass']);
            if($_POST["s"]!="0"){$user_pass = md5($user_pass);}
            $sql = $mysqli->query("SELECT user_id, user_name, user_pass, user_type FROM users WHERE user_name='".$user_name."' AND user_pass='".$user_pass."'");
            if($row = $sql->fetch_array()) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row["user_name"];
                $_SESSION['user_pass'] = $user_pass;
                $_SESSION['user_type'] = $row["user_type"];
                if($_POST["s"]!="0"){header("Location: ../index.php");}
                else{echo "Reconectado";}
            }else {
?>
                Error, <a href="../index.php">Reintentar</a>
<?php
            }
        }
    }else {
        if($_POST["s"]!="0"){header("Location: ../index.php");}
    }
?>