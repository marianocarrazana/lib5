<?php
$host_db = "localhost"; // Host de la BD
$usuario_db = "user"; // Usuario de la BD
$clave_db = "pass"; // Contraseña de la BD
$nombre_db = "lib5"; // Nombre de la BD
if(!isset($avoid_sql)){
	$mysqli = new mysqli($host_db, $usuario_db, $clave_db, $nombre_db);
}
?>