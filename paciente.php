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

    //Consultar los datos del USUARIO CLIENTE
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
                $user = $row['user'];
                $password = $row['password'];
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
        $stmt->close();
    } else{
        echo 'Error intente mas tarde';
    }

    //Proceso de actualización de información
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Se valida que los campos a actualizar no estén vacíos la función es isset
        if(isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['ciudad'] ) && isset($_POST['direccion']) && isset($_POST['password'])){
            echo "Entrasmo";
          //Se detalla la consulta
          $sql="UPDATE paciente SET correo=?, telefono=?, ciudad=?, direccion=?, password=? WHERE idPaciente=?";
        //   //Se prepara la consulta
          if($stnt = $conn->prepare($sql)){
            //Se establecen los parámetros
            //sssi significa que se van a pasar 5 parámetros de tipos string y 1 entero representado por la i de integer que es el id
            $stnt->bind_param("sssssi", $_POST['correo'], $_POST['telefono'], $_POST['ciudad'], $_POST['direccion'], $_POST['password'], $id);
            //Se ejecuta la sentencia
            if($stnt->execute()){
              //Si todo sale bien se recarga la página
              header("location: paciente.php");
              exit();
            }else{
              //Caso contrario muestra un mensaje de error
              echo "Error, intente de nuevo";
            }
            //Se cierra el stament de preparación que nos ayudó a ejecutar la solicitud
            $stnt->close();
          }
        }
    }

    //Consultamos los datos de las citas según el ID del médico almacenado en Sesión
    //Se detalla la consulta
    $consulta2 = "SELECT c.fecha, c.hora, m.nombres, m.apellido_paterno, m.cedula, m.telefono, m.correo, m.edad FROM cita as c, medico as m WHERE c.idMedico = m.idMedico AND c.idMedico = ?";
    //Se prepara la consulta
    if ($stmt2 = $conn->prepare($consulta2)) {
      //Se establecen los parámetros
      //En este caso la i representa que se va a pasar un dato entero 
      $stmt2->bind_param("i", $id);
      //Se ejecuta la sentencia
      if ($stmt2->execute()) {
        //Se alamacenan los resultados en una variable
        $result2 = $stmt2->get_result();
      } else {
        //Se detalla el error
        echo "Error! Intente más tarde";
        exit();
      }
      //Se cierra el stament de preparación que nos ayudó a ejecutar la solicitud
      $stmt2->close();
    }

    require_once 'paciente.html'   

  
?>

