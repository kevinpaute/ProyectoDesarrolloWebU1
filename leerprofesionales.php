<?php
//conexion
require_once "conexion.php";
//control del parametro enviado
if(isset($_GET['id']) && !empty(trim($_GET["id"]))){
    $consulta = "SELECT nombres,  apellido_paterno, apellido_materno, correo, telefono, direccion, nmbres, foto  FROM medico, especialidad WHERE (medico.idEspecialidad = especialidad.idEspecialidad) AND (idMedico=?) ";
    
    if($stmt = $conn -> prepare($consulta)){
        $stmt -> bind_param('i', $_GET["id"]);
        if($stmt -> execute()){
            $result=$stmt->get_result();
            if($result->num_rows==1){
                $row=$result->fetch_array(MYSQLI_ASSOC);
                $nombres = $row['nombres'];;
                $apellidos = $row['apellido_paterno']. " " . $row['apellido_materno'];
                $correo = $row['correo'];
                $telefono = $row['telefono'];
                $direccion = $row['direccion'];
                $especialidad = $row['nmbres'];
                $foto = $row['foto'];                
            }else{
                echo 'Error! No existen resultados.';
                exit();
            }
        }
    }
    $stmt -> close();
    $conn -> close();
}else{
    echo "Error! Intente mas tarde.";
    exit();
}
require_once "leerprofesional.html";

?>