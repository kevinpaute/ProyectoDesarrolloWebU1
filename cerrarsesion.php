<?php
session_start(); // Iniciar una nueva sesión o reanudar la existente
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye los objetos creados de la sesión

echo "<script>alert('Sesión cerrada correctamente');</script>";

require_once('login.php');

?>

