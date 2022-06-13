<?php

require_once 'conexion.php';

//Registrar paciente en la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Configurar variables para almacenar datos del formulario
    if(isset ($_POST['cedula']) && isset($_POST['username']) &&
    isset ($_POST ['lastname']) && isset ($_POST ['lastname2']) &&
    isset ($_POST ['email']) &&  isset ($_POST ['fecha']) && isset($_POST['edad'])
    && isset ($_POST ['telefono']) && isset ($_POST ['ciudad']) && isset ($_POST ['direccion']) && isset($_POST['foto'])
    && isset ($_POST ['user']) && isset ($_POST ['password']) && isset($_POST['especialidad']) && isset($_POST['horario'])){
        // Configurar consulta para insertar datos en la tabla contactos
        $sql = "INSERT INTO medico (cedula, nombres, apellido_paterno, apellido_materno, correo, fNacimiento, edad, telefono, ciudad, direccion, foto, user, password, idEspecialidad, idHorario) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Verificar si la consulta se ejecuto correctamente

        if ($stmt = $conn->prepare($sql)) { 
            // Configurar parametros de la consulta
            $stmt->bind_param( "sssssssssssssss", $_POST['cedula'], $_POST['username'], $_POST
            ['lastname'], $_POST['lastname2'], $_POST['email'], $_POST['fecha'], $_POST['edad'], $_POST
            ['telefono'], $_POST ['ciudad'], $_POST['direccion'], $_POST['foto'], $_POST['user'], $_POST['password'], $_POST['especialidad'], $_POST['horario']);
            if ($stmt->execute()) {
                header('Location: index.php');
                exit();
            } else {
                echo "Error al insertar datos, intente más tarde";    
            }

            // Cerrar consulta
            $stmt->close();
        } else {
            echo "Error al preparar consulta, intente más tarde";
        }

    } else {
        echo "Error al enviar datos del formulario, intente más tarde";
    }
    // Cerrar conexión
    $conn->close();
}


require_once "registroMedico.html";
?>