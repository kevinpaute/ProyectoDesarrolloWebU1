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
        // echo('bryanSolórzano, conexión exitosa');
    }
?>