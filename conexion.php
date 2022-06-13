<<<<<<< HEAD
<?php
    // Datos para la conexión hacia la base
    define('SERVERNAME', 'localhost');
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('DBNAME', 'clinica');

    // Creación de la conexión con la libreria mysqli
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    // Controlar la conexión 
    if($conn -> connect_error){
        die('Conexión fallida: '. $conn -> connect_error);
    } else{
      
    }
=======

<?php

$servername = "localhost";  //Nombre del servidor
$username = "root"; //Usuario de la base de datos
$password = "";     //Contraseña de la base de datos
$dbname = "clinica"; //Nombre de la base de datos

 // Crear coenxion
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

>>>>>>> 071f26689cd72eaeae6aad90b56ef732b2053d27
?>