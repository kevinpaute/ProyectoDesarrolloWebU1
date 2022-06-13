<?php

include 'conexion.php';

// $query4 = "SELECT * FROM citas as c, paciente as p WHERE c.idPaciente = p.idPaciente AND c.idMedico = m.idMedico";
//si el formulario se envia inserta en la base de datos los datos para registrar una cita
if(isset($_POST['submit2'])){
    $cedulaPaciente = $_POST['cedula'];
    $cedulaMedico = $_POST['cedulaMedico'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    $query5 = "SELECT idPaciente, nombres FROM paciente WHERE cedula = $cedulaPaciente";
    $query6 = "SELECT idMedico, nombres FROM medico WHERE cedula = $cedulaMedico";

    //Motrar en una tabla el query5
    $resultado5 = mysqli_query($conn, $query5);

    //almacenar en variables el resultado de la consulta
    $fila = mysqli_fetch_array($resultado5);

    $idP = $fila['idPaciente'];
    $nombres = $fila['nombres'];


    //Motrar en una tabla el query6
    $resultado6 = mysqli_query($conn, $query6);

    $fila1 = mysqli_fetch_array($resultado6);

    $idM = $fila1['idMedico'];
    $nombres1 = $fila1['nombres'];


    //Si la consulta no da error entonces se inserta en la base de datos
    if(!$resultado5 || !$resultado6){
        echo "Error al registrar la cita";
    }else{

        $query = "INSERT INTO cita (fecha, hora, idPaciente, idMedico) VALUES ($fecha, $hora, $idP, $idM)";
        $result = mysqli_query($conn, $query) or die(mysqli_connect_error());
        echo '<script>alert("Cita registrada");</script>';
       
    }
}

?>
<?php

//Formulario HTML para registrar cita con cedula paciente y cedula medico
echo '<form action="a1.php" method="post">';
echo '<label>Cedula Paciente:</label>';
echo '<input type="text" name="cedula" placeholder="Cedula">';
echo '<br>';
echo '<label>Cedula Medico :</label>';
echo '<input type="text" name="cedulaMedico" placeholder="Cedula Medico">';
echo '<br>';
echo '<label>Fecha:</label>';
echo '<input type="text" name="fecha" placeholder="Fecha">';
echo '<br>';
echo '<label>Hora:</label>';
echo '<input type="text" name="hora" placeholder="Hora">';
echo '<input type="submit" name="submit2" value="Consultar">';

echo '</form>';

?>
