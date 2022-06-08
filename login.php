<?php


$user = $_POST['user'];
$pass = $_POST['password'];

//Los datos se reciben del formulario para logearse
if(isset($user)){
    //Crear variables de conexión
    define('SERVERNAME','localhost');
    define('USERNAME','root');
    define('PASSWORD','');
    define('DBNAME','clinica');

    //Se crea la conexión con la base de datos
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME) or
    die('Error en la conexión');

    //Inicia la sesión
    session_start();

    $query = "SELECT * FROM paciente WHERE user = '$user' AND password = '$pass'";
    $query2 = "SELECT * FROM medico WHERE user = '$user' AND password = '$pass'";
    $query3 = "SELECT * FROM direccion WHERE user= '$user' AND password = '$pass'";

    $result = mysqli_query($conn, $query) or die(mysqli_connect_error());
    $result2 = mysqli_query($conn, $query2) or die(mysqli_connect_error());
    $result3 = mysqli_query($conn, $query3) or die(mysqli_connect_error());

    //Almacena el o los datos en un arreglo y toma el siguiente
    $registro = mysqli_fetch_array($result);
    $registro2 = mysqli_fetch_array($result2);
    $registro3 = mysqli_fetch_array($result3);

    
    if($registro2['idMedico'] != null){
        $_SESSION['id']=$registro2['idMedico']; 
        $_SESSION['nombre']=$registro2['nombres'];
        header('Location: medicos.php');
    }
    else if($registro['idPaciente'] != null){
        $_SESSION['id']=$registro['idPaciente']; 
        $_SESSION['nombre']=$registro['nombres'];
        header('Location: paciente.php');
    }
    else if($registro3['idDireccion'] != null){
        $_SESSION['id']=$registro3['idDireccion']; 
        $_SESSION['nombre']=$registro3['nombres'];
        header('Location: direccion.php');
    }
    else{
        echo '<script>alert("Usuario o contraseña incorrectos");</script>';
        header('Location: login.php');
    }

    //Si el usuario y contraseña son correctos
//     if ($registro['idPaciente']==null){
//         if ($registro2['idMedico']==null){
//             if ($registro3['idDireccion']==null){
//                 //Si es nulo redirige al mismo formulario
//                 header('Location: login.html');
//             }else{
//                 //Se define las variables de sesión y se redirige a la página de usuario
//                 $_SESSION['id']=$registro3['idDireccion']; 
//                 $_SESSION['nombre']=$registro3['nombres'];
//                 header('Location: citas.html');
//             }
//         }else{
//             //Se define las variables de sesión y se redirige a la página de usuario
//             $_SESSION['id']=$registro2['id_medico']; 
//             $_SESSION['nombre']=$registro2['nombres'];
//             header('Location: medicos.html');
//         }
//     }else{
//         //Se define las variables de sesión y se redirige a la página de usuario
//         $_SESSION['id']=$registro['id_paciente']; 
//         $_SESSION['nombre']=$registro['nombres'];
//         header('Location: paciente.php');
//     }
}else{
    header("location:login.html"); //Redireccionamos a la pagina principal
}


require_once 'login.html';

?>