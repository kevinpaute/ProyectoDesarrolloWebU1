<?php
    //Iniciar sesion
    session_start();
    if (!$_SESSION) {
        header("location:login.html");
      }
      //Instanciamos la conexión
    require_once "conexion.php";
    
    //Se obtienen los datos de la sesión, es decir los datos del médico logeado
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];

    //Consulta de datos
    $consulta = 'SELECT idPaciente, nombres, apellido_paterno, apellido_materno, cedula, correo, fNacimiento, edad, telefono,ciudad, direccion, foto, user, password FROM paciente WHERE idPaciente = ?';

    // Preparar la sentencia
    if($stmt = $conn -> prepare($consulta)){
        $stmt -> bind_param('i', $id);
        //Ejecutar la sentencia
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            if($result -> num_rows == 1){
                $row = $result -> fetch_array(MYSQLI_ASSOC);
                $id_paciente = $row['idPaciente'];
                $nombres = $row['nombres'];
                $apellidoPaterno = $row['apellido_paterno'];
                $apellidoMaterno = $row['apellido_materno'];
                $cedula = $row['cedula'];
                $correo = $row['correo'];
                $fNacimiento = $row['fNacimiento'];
                $edad = $row['edad'];
                $telefono = $row['telefono'];
                $ciudad = $row['ciudad'];
                $direccion = $row['direccion'];
                $foto = $row['foto'];
                $user = $row['user'];
                $password = $row['password'];
            }else{
                echo 'Error, No existen los datos';
                exit();
            }
        }else{
            echo 'Error! Revise la conexión con al base de datos';
            exit();
        } 



    $query = 'SELECT cita.*, medico.* FROM `cita` INNER JOIN paciente ON cita.idPaciente = paciente.idPaciente INNER JOIN medico ON cita.idMedico = medico.idMedico;';
        

    // Preparar la sentencia

    if($stmt = $conn -> prepare($query)){
        // Ejecución de la entencia
        if($stmt -> execute()){
            $result = $stmt -> get_result();
            if($result -> num_rows > 0){
                $row = $result -> fetch_array(MYSQLI_ASSOC);
                $idCita = $row['idCita'];
                $idMedico = $row['idMedico'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];
                $correoMedico = $row['correo'];
                $apellidoMedico = $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
                $nombresMedico = $row['nombres'];
            }else{
                echo 'Error, No existen los datos';
                exit();
            }
        }else{
            echo 'Error! Revise la conexión con al base de datos';
            exit();
        }


    }else{
        echo 'Error, No existen los datos';
        exit();
    }

} else{
    echo 'Error intente mas tarde';
}

require_once 'paciente.html'   

  
?>

