<?php
session_start();
 include('access_db.php');
    if(isset($_POST['send'])) { 
        if($_POST['reg']!="cx7"){die("Clave de registro incorrecta");};
        function email_validate($mail) {
            if (preg_match('/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/', $mail)) return true;
            else return false;
        }
        // Procedemos a comprobar que los campos del formulario no estén vacíos
        $sin_espacios = count_chars($_POST['user_name'], 1);
        if(!empty($sin_espacios[32])) { // comprobamos que el campo user_name no tenga espacios en blanco
            echo "El campo <em>user_name</em> no debe contener espacios en blanco. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(empty($_POST['user_name'])) { // comprobamos que el campo user_name no esté vacío
            echo "No haz ingresado tu usuario. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(empty($_POST['user_pass'])) { // comprobamos que el campo user_pass no esté vacío
            echo "No haz ingresado contraseña. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif($_POST['user_pass'] != $_POST['user_pass_conf']) { // comprobamos que las contraseñas ingresadas coincidan
            echo "Las contraseñas ingresadas no coinciden. <a href='javascript:history.back();'>Reintentar</a>";
        }elseif(!email_validate($_POST['user_mail'])) { // validamos que el email ingresado sea correcto
            echo "El email ingresado no es válido. <a href='javascript:history.back();'>Reintentar</a>";
        }else {
            // "limpiamos" los campos del formulario de posibles códigos maliciosos
            $user_name = $mysqli->real_escape_string($_POST['user_name']);
            $user_pass = $mysqli->real_escape_string($_POST['user_pass']);
            $user_mail = $mysqli->real_escape_string($_POST['user_mail']);
            // comprobamos que el usuario ingresado no haya sido registrado antes
            $sql = $mysqli->query("SELECT user_name FROM users WHERE user_name='".$user_name."'");
            if($sql->num_rows > 0) {
                echo "El nombre usuario elegido ya se encuentra registrado. Utilice el botón INGRESAR para acceder a la página <a href='../index.php?ur=".$_SERVER["HTTP_REFERER"]."'>Reintentar</a>";
            }else {
                $user_pass = md5($user_pass);
                $reg = $mysqli->query("INSERT INTO users (user_name, user_pass, user_mail, user_datereg) VALUES ('".$user_name."', '".$user_pass."', '".$user_mail."',  NOW())");
                if($reg) {
                        $sql = $mysqli->query("SELECT user_id, user_name, user_pass, user_type FROM users WHERE user_name='".$user_name."' AND user_pass='".$user_pass."'");
            if($row = $sql->fetch_array()) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row["user_name"];
                $_SESSION['user_pass'] = $user_pass;
                $_SESSION['user_type'] = $row["user_type"];
                header("Location: ../index.php");
            }
                }else {
                    echo "ha ocurrido un error y no se registraron los datos.";
                }
            }
        }
    }
   ?>