<?php
session_start();
if (!$_SESSION) {
  header("location:login.html");
}
//Instanciamos la conexión
require_once "conexion.php";

//Se obtienen los datos de la sesión, es decir los datos del médico logeado
$id = $_SESSION['idDireccion'];
$nombre = $_SESSION['nombres'];


//Consultamos los datos del médico según su ID almacenado en Sesión
//Se detalla la consulta
$consulta = "SELECT d.idDireccion, d.nombres, d.apellido_paterno, d.apellido_materno, d.correo, d.roles, d.telefono, d.ciudad, d.foto, d.user, d.password FROM direccion as d WHERE d.idDireccion = ?";
//preparar la consulta
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
        $param_id_direccion = $row["idDireccion"];
        $param_nombre_direccion = $row["nombres"];
        $param_apellido_direccion = $row["apellido_paterno"];
        $param_apellido_materno_direccion = $row["apellido_materno"];
        $param_correo_direccion = $row["correo"];
        $param_telefono_direccion = $row["telefono"];
        $param_ciudad_direccion = $row["ciudad"];
        $param_foto_direccion = $row["foto"];
        $param_user_direccion = $row["user"];
        $param_password_direccion = $row["password"];
       
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
$conn->close();



require_once "secretaria.html";
?>