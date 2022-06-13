<?php
session_start();
if (!$_SESSION) {
    header("location:login.html");
}

//Instanciamos la conexión
require_once "conexion.php";

//Se obtienen los datos de la sesión, es decir los datos del médico logeado
$id = $_SESSION['id'];
// if(isset($_POST["userImage"])){
$b = getimagesize($_FILES["userImage"]["tmp_name"]);
//Check if the user has selected an image
if ($b !== false) {
    //Get the contents of the image
    $file = $_FILES['userImage']['tmp_name'];
    $image = addslashes(file_get_contents($file));

    //Insert the image into the database
    $query = $conn->query("UPDATE medico set foto = '$image' where idMedico = $id");
    if ($query) {
        header("location: medicos.php");
    } else {
        echo "File upload failed.";
    }
} else {
    echo "Please select an image to upload.";
}
// }else{
//     echo "No Llego";
// }
