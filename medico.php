<?php
//si no hay sesión se redirige al login
session_start();
if (!$_SESSION) {
  header("location:login.html");
}
//Instanciamos la conexión
require_once "conexion.php";

//Se obtienen los datos de la sesión, es decir los datos del médico logeado
$id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];

//Consultamos los datos del médico según su ID almacenado en Sesión
//Se detalla la consulta
$consulta = "SELECT m.idMedico, m.nombres, m.apellido_paterno, m.apellido_materno, m.cedula, m.telefono, m.correo, m.ciudad, m.direccion, m.fNacimiento, m.edad, m.foto, m.user, m.password, h.dias, h.hora_ingreso,  h.hora_salida, e.nmbres FROM medico as m, especialidad as e, horario as h WHERE h.idHorario = m.idHorario AND e.idEspecialidad = m.idEspecialidad AND m.idMedico = ?";
if ($stmt = $conn->prepare($consulta)) {
  //Se establecen los parámetros
  //En este caso la i representa que se va a pasar un dato entero 
  $stmt->bind_param("i", $id);
  //Se ejecuta la sentencia con los parámetros establecidos
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    //Se recorre el resultado y se almacena en variables para poder ocuparlas en el HTML
    if ($result->num_rows == 1) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $param_id_medico = $row["idMedico"];
      $param_nombre_medico = $row["nombres"];
      $param_cedula_medico = $row["cedula"];
      $param_apellido_medico = $row["apellido_paterno"];
      $param_apellido_materno_medico = $row["apellido_paterno"];
      $param_telefono_medico = $row["telefono"];
      $param_correo_medico = $row["correo"];
      $param_ciudad_medico = $row["ciudad"];
      $param_direccion_medico = $row["direccion"];
      $param_fnacimiento_medico = $row["fNacimiento"];
      $param_edad_medico = $row["edad"];
      $param_foto_medico = $row["foto"];
      $param_user_medico = $row["user"];
      $param_password_medico = $row["password"];
      $param_nombre_especialidad = $row["nmbres"];
      $param_dias_horario = $row["dias"];
      $param_hora_ingreso = $row["hora_ingreso"];
      $param_hora_salida = $row["hora_salida"];
    } else {
      echo "Error. Datos no encontrados";
      exit();
    }
  } else {
    echo "Error! Intente más tarde";
    exit();
  }
  $stmt->close();
}

//Simple parseo para mostrar en la tabla es para almacenar la hora de entrada y salida en el dia correspondiente
$lunes = "";
$martes = "";
$miercoles = ""; // se inicializa y almacena la hora de entrada y salida en el dia correspondiente
$jueves = "";
$viernes = "";
$sabado = "";
$domingo = "";
if ($param_dias_horario == "Lunes") {
  $lunes = "$param_hora_ingreso - $param_hora_salida";
} else {
  $lunes = "No hay registros";
}
if ($param_dias_horario == "Martes") {
  $martes = "$param_hora_ingreso - $param_hora_salida";
} else {
  $martes = "No hay registros";
}
if ($param_dias_horario == "Miercoles") {
  $miercoles = "$param_hora_ingreso - $param_hora_salida";
} else {
  $miercoles = "No hay registros";
}
if ($param_dias_horario == "Jueves") {
  $jueves = "$param_hora_ingreso - $param_hora_salida";
} else {
  $jueves = "No hay registros";
}
if ($param_dias_horario == "Viernes") {
  $viernes = "$param_hora_ingreso - $param_hora_salida";
} else {
  $viernes = "No hay registros";
}
if ($param_dias_horario == "Sabado") {
  $sabado = "$param_hora_ingreso - $param_hora_salida";
} else {
  $sabado = "No hay registros";
}
if ($param_dias_horario == "Domingo") {
  $domingo = "$param_hora_ingreso - $param_hora_salida";
} else {
  $domingo = "No hay registros";
}

//Consultamos los datos de las citas según el ID del médico almacenado en Sesión
//Se detalla la consulta
$consulta2 = "SELECT c.idCita, c.fecha, c.hora, p.nombres, p.apellido_paterno, p.cedula, p.telefono, p.correo, p.edad FROM cita as c, paciente as p WHERE c.idPaciente = p.idPaciente AND c.idMedico = ?";
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

//Proceso de actualización de información
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Se valida que los campos a actualizar no estén vacíos la función es isset, puedes revisar mas en la documentación de PHP
  if (isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['ciudad'])) {
    //Se detalla la consulta
    $sql = "UPDATE medico SET correo=?, telefono=?, ciudad=?, direccion=?, password=? WHERE idMedico=?";
    //Se prepara la consulta
    if ($stnt = $conn->prepare($sql)) {
      //Se establecen los parámetros
      //sssi significa que se van a pasar 5 parámetros de tipos string y 1 entero representado por la i de integer que es el id
      $stnt->bind_param("sssssi", $_POST['correo'], $_POST['telefono'], $_POST['ciudad'], $_POST['direccion'], $_POST['password'], $id);
      //Se ejecuta la sentencia
      if ($stnt->execute()) {
        //Si todo sale bien se recarga la página
        header("location: medicos.php");
        exit();
      } else {
        //Caso contrario muestra un mensaje de error
        echo "Error, intente de nuevo";
      }
      //Se cierra el stament de preparación que nos ayudó a ejecutar la solicitud
      $stnt->close();
    }
  }
}

//Se cierra la conexión
$conn->close();
require_once "medico.html";

?>