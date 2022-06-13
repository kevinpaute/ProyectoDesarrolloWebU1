<<<<<<< HEAD
<?php


$user = $_POST['user'];
$pass = $_POST['password'];

//Los datos se reciben del formulario para logearse
if(isset($user)){
    //Crear variables de conexión
    define('SERVERNAME','localhost');
    define('USERNAME','root');
    define('PASSWORD','');
    define('DBNAME','db_prueba');

    //Se crea la conexión con la base de datos
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME) or
    die('Error en la conexión');

    //Inicia la sesión
    session_start();

    $query = "SELECT * FROM paciente WHERE user = '$user' AND password = '$pass'";
    $query2 = "SELECT * FROM medico WHERE user = '$user' AND password = '$pass'";
    $query3 = "SELECT * FROM direccion WHERE user= '$user' AND password = '$pass'";

    // $result = mysqli_query($conn, $query) or die(mysqli_connect_error());
    $result2 = mysqli_query($conn, $query2) or die(mysqli_connect_error());
    // $result3 = mysqli_query($conn, $query3) or die(mysqli_connect_error());

    //Almacena el o los datos en un arreglo y toma el siguiente
    // $registro = mysqli_fetch_array($result);
    $registro2 = mysqli_fetch_array($result2);
    if($registro2['idMedico'] != null){
        $_SESSION['id']=$registro2['idMedico']; 
        $_SESSION['nombre']=$registro2['nombres'];
        header('Location: medicos.php');
    }
    // $registro3 = mysqli_fetch_array($result3);

    //Si el usuario y contraseña son correctos
    // if ($registro['idPaciente']==null){
    //     if ($registro2['idMedico']==null){
    //         if ($registro3['idDireccion']==null){
    //             //Si es nulo redirige al mismo formulario
    //             header('Location: login.html');
    //         }else{
    //             //Se define las variables de sesión y se redirige a la página de usuario
    //             $_SESSION['id']=$registro3['idDireccion']; 
    //             $_SESSION['nombre']=$registro3['nombres'];
    //             header('Location: citas.html');
    //         }
    //     }else{
    //         //Se define las variables de sesión y se redirige a la página de usuario
    //         $_SESSION['id']=$registro2['idMedico']; 
    //         $_SESSION['nombre']=$registro2['nombres'];
    //         header('Location: medicos.php');
    //     }
    // }else{
    //     //Se define las variables de sesión y se redirige a la página de usuario
    //     $_SESSION['id']=$registro['id_paciente']; 
    //     $_SESSION['nombre']=$registro['nombres'];
    //     header('Location: medicos.php');
    // }
}else{
    header("location:login.html"); //Redireccionamos a la pagina principal
}
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html> -->
=======

<?php

require_once 'index.html';

?>
>>>>>>> 071f26689cd72eaeae6aad90b56ef732b2053d27
