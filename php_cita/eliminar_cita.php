<?php 
include("../include/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM cita WHERE idCita = $id";
    $resultado = mysqli_query($conexion,$query);

    if(!$resultado){
        die("Query Failed"); 
    }

    // $_SESSION["message"] = 'Tarea Eliminada';
    // $_SESSION["message_type"] = "danger";
    header("Location: citas_1.php");
}
?>