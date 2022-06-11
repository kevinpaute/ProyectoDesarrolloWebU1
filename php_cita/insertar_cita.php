<?php
error_reporting(0);
header('Content-type: application/json; charset=utf-8');

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$medico = $_POST['medico'];
$pasiente = $_POST['pasiente'];

function validarDatos($fecha,$hora ,$medico,$pasiente){
    //VALIDANDO FORMULARIO
    if ($fecha == '') {
        return false;
    }elseif($hora == ''){
        return false;
    }elseif($medico == ''|| is_int($medico)){
        return false;
    }elseif($pasiente== ''|| is_int($pasiente)){
        return false;
    }
    return true;//En caso de que todo este correcto
}


if (validarDatos($fecha,$hora ,$medico,$pasiente)) {
    include("../include/db.php");
    $conexion->set_charset("utf8");//conjunto de caracteres que permite la base de datos

    //para identifaar si exite un error
    if ($conexion->connect_errno) {
        $resuesta = ['error' => true];
    }else{
        //PREPARANDO PARA HACER UNA INSERCION 
        
        $statement = $conexion->prepare("INSERT INTO cita (fecha,hora,idPaciente ,idMedico) VALUES(?,?,?,?) ");

        //muy impornta en esta parte con cada una de las letas siss
        $statement -> bind_param("ssii",$fecha,$hora,$pasiente,$medico);
        $statement->execute();

        //EN CASO QUE LAS FILAS SEAN MENOR O IGUALES A 0 NO SE AGREGO NIGUN VALOR
        if($conexion->affected_rows <= 0){
            //puedo ubicar cualquier valor al arreglo
            $resuesta = ['error' => true];
        }

        $resuesta = [];

    }
}else{
    $resuesta = ['error' => true];
}

//SI NO DA UN ERROR RESPUESTA VA A SER NULO
echo json_encode($resuesta);
?>