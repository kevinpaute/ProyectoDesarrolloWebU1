<?php
//si no hay sesión se redirige al login
session_start();
if (!$_SESSION) {
	header("location:login.html");
}
//Instanciamos la conexión
require_once "conexion.php";

//Proceso para actualizar fecha y hora en 0 para no alterar la tabla y que se entienda que se ha cancelado la cita
if (isset($_GET['id'])) {
	//Se toman los datos
	$id = $_GET['id'];
	//Se detalla la consulta
	$query = $conn->query("UPDATE cita SET fecha = '00-00-00', hora = '00:00' WHERE idCita = $id");
	if ($query) {
		header("location: medicos.php");
	} else {
		echo "Algo ha salido mal intentenuevamente.";
	}
}

//Se cierra la conexión
$conn->close();