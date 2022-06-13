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

    $query = "SELECT * FROM direccion WHERE user= '$user' AND password = '$pass'";
    $query2 = "SELECT * FROM medico WHERE user = '$user' AND password = '$pass'";
   


    $result = mysqli_query($conn, $query) or die(mysqli_connect_error());
    $result2 = mysqli_query($conn, $query2) or die(mysqli_connect_error());

 



    //Almacena el o los datos en un arreglo y toma el siguiente
    $registro = mysqli_fetch_array($result);

    if($registro['roles'] == 'Gerente'){
        $_SESSION['id']=$registro['idDireccion']; 
        $_SESSION['nombre']=$registro['nombres'];
        header('Location: php_cita/citas_1.php');
    }else if ($registro['roles'] == 'Secretaria'){
        $_SESSION['id']=$registro['idDireccion']; 
        $_SESSION['nombre']=$registro['nombres'];
        header('Location: php_cita/citas_1_1.php');
    }else if($registro['roles'] == 'Supervisor'){
        $_SESSION['id']=$registro['idDireccion']; 
        $_SESSION['nombre']=$registro['nombres'];
        header('Location: php_cita/citas_1.php');

    }else if($registro2['idMedico'] != null){
        $_SESSION['id']=$registro2['idMedico']; 
        $_SESSION['nombre']=$registro2['nombres'];
        header('Location: medico.php');
    }else{
        header('Location: login2.php');
    }


}else{
    header("location:login2.html"); //Redireccionamos a la pagina principal
}


require_once 'login2.html';

?>

