<?php 
error_reporting(0);
header('Content-type: application/json; charset=utf-8');
include("../include/db.php");

if ($conexion->connect_errno) {
    $respuesta = ['error'=> true];
}else{
    $conexion->set_charset("utf8");//PARA NO TENER PROBLEMAS CON LOS CARACTERES

    $statement = $conexion->prepare('SELECT paciente.cedula as cpaciente, medico.cedula as cmedico ,fecha,hora,	idCita FROM cita
    INNER JOIN medico ON cita.idMedico = medico.idMedico
    INNER JOIN paciente ON cita.idPaciente = paciente.idPaciente');
    $statement->execute();//SIN ESO NO EJECUTA
    $resultados = $statement->get_result();//PARA OBTENER LOS DATOS DE LA CONSULTA

    // echo '<pre>';
    // var_dump($resultados->fetch_assoc());fetch para que muestre el resultado
    // echo '</pre>';

    $respuesta = [];
    //UN ARREGLO POR CADA UNO DE LOS RESSULTADOS QUE OBTENEMOS
    while($fila = $resultados->fetch_assoc()){
        $usuario = [
            'fecha'        => $fila['fecha'],
            'hora'    => $fila['hora'],
            'medico'  => $fila['cpaciente'],
            'paciente'      => $fila['cmedico'],
            'cita'      => $fila['idCita']

        ];
        array_push($respuesta,$usuario);//para ingresar un arreglo de arrelgos 
    }
}
echo json_encode($respuesta);
?>