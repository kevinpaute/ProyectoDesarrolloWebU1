<?php 
include("../include/db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['pasiente']) && isset($_POST['medico'])) {
        $query = "INSERT INTO cita (fecha,hora,idPaciente ,idMedico) VALUES (?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($query)) {

            // echo '<td>'.$row['id_login'].'</td>';
            // echo '<td>'.$row['user_log'].'</td>';
            // echo '<td>'.$row['nombre_log'].'</td>';
            // echo '<td>'.$row['email'].'</td>';
            // echo '<td>'.$row['ciudad'].'</td>';
            $stmt->bind_param('ssii', $_POST['fecha'], $_POST['hora'], $_POST['pasiente'], $_POST['medico']);

            //ejecutamos setencia
            if ($stmt->execute()) {
     
                header("Location: citas_1.php");
                exit();
            } else {
       
                header("Location: citas_1.php");
            }

            $stmt->close();
        }
    }
}







?> 