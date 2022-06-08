<?php
require_once 'conexion.php';
$consulta = "SELECT * FROM datos";
$result = $conn ->query($consulta);
require_once 'index.html';
?>