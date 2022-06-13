<?php 
require_once "conexion.php";

if(isset($_POST['submit2'])){
  $cedulaPaciente = $_POST['cedula'];
  $cedulaMedico = $_POST['cedulaMedico'];
  $fecha5 = $_POST['fecha'];
  $hora5 = $_POST['hora'];

  $query5 = "SELECT idPaciente, nombres FROM paciente WHERE cedula = $cedulaPaciente";
  $query6 = "SELECT idMedico, nombres FROM medico WHERE cedula = $cedulaMedico";

  //Motrar en una tabla el query5
  $resultado5 = mysqli_query($conn, $query5);

  //almacenar en variables el resultado de la consulta
  $fila = mysqli_fetch_array($resultado5);

  $idP = $fila['idPaciente'];
  //Motrar en una tabla el query6
  $resultado6 = mysqli_query($conn, $query6);

  $fila1 = mysqli_fetch_array($resultado6);

  $idM = $fila1['idMedico'];
  echo $cedulaPaciente;

  //Si la consulta no da error entonces se inserta en la base de datos
  if(!$resultado5 || !$resultado6){
      echo "Error al registrar la cita";
  }else{
      $query9 = "INSERT INTO cita (fecha, hora, idPaciente, idMedico) VALUES ($fecha5, $hora5, $idP, $idM)";
      header("location: secretarias.php");
  }
}



?>