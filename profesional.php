<?php
//conexion
require_once "conexion.php";
//control del parametro enviado

$consulta = "SELECT idMedico, nombres, apellido_paterno, apellido_materno, nmbres FROM medico, especialidad WHERE medico.idEspecialidad = especialidad.idEspecialidad";
$resultado = $conn->query($consulta) or die("Algo salió mal en la consulta de la BDD");

require_once "profesionales.html"
?>