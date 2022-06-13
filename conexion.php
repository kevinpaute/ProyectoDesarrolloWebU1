
<?php

$servername = "localhost";  //Nombre del servidor
$username = "root"; //Usuario de la base de datos
$password = "";     //Contraseña de la base de datos
$dbname = "clinica2"; //Nombre de la base de datos

 // Crear coenxion
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

?>