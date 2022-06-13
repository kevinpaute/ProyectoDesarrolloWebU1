<?php 
require_once "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM cita WHERE idCita = $id";
    $resultado = mysqli_query($conn,$query);

    if(!$resultado){
        die("Query Failed"); 
    }

    // $_SESSION["message"] = 'Tarea Eliminada';
    // $_SESSION["message_type"] = "danger";
    header("Location: secretarias.php");

}
?>