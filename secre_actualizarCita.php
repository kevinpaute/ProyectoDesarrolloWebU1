<?php
//si no hay sesión se redirige al login
session_start();
if (!$_SESSION) {
    header("location:login.html");
}
//Instanciamos la conexión
require_once "conexion.php";

//Consultamos los datos de la cita
if (isset($_GET['id'])) {
    $consulta = "SELECT c.fecha, c.hora, p.nombres, p.apellido_paterno, p.cedula, p.telefono, p.correo, p.edad FROM cita as c, paciente as p WHERE c.idPaciente = p.idPaciente AND c.idCita = ?";
    if ($stmt = $conn->prepare($consulta)) {
        //Se establecen los parámetros
        //En este caso la i representa que se va a pasar un dato entero 
        $stmt->bind_param("i", $_GET['id']);
        //Se ejecuta la sentencia con los parámetros establecidos
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            //Se recorre el resultado y se almacena en variables para poder ocuparlas en el HTML
            if ($result->num_rows == 1) {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $param_fecha_cita = $row["fecha"];
                $param_hora_cita = $row["hora"];
                $param_nombres_paciente = $row["nombres"];
                $param_apellido_paciente = $row["apellido_paterno"];
                $param_cedula_paciente = $row["cedula"];
                $param_telefono_paciente = $row["telefono"];
                $param_correo_paciente = $row["correo"];
                $param_edad_paciente = $row["edad"];
            } else {
                echo "Error. Datos no encontrados";
                exit();
            }
        } else {
            echo "Error! Intente más tarde";
            exit();
        }
        $stmt->close();
    }
}

//Proceso de actualización de información
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Se valida que los campos a actualizar no estén vacíos la función es isset, puedes revisar mas en la documentación de PHP
    if (isset($_POST['fecha']) && isset($_POST['hora'])) {
        //Se detalla la consulta
        $id = $_GET['id'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $query = $conn->query("UPDATE cita SET fecha = '$fecha', hora = '$hora' WHERE idCita = $id");
    if ($query) {
        header("location: secretarias.php");
    } else {
        echo "Algo ha salido mal intentenuevamente.";
    }
    }
}

//Se cierra la conexión
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Íconos Fontawsome -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <script src="https://kit.fontawesome.com/0ea7a89597.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,600&display=swap" rel="stylesheet" />
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Bevan' rel='stylesheet'>
    <!-- CSS propio -->
    <link rel="stylesheet" href="css/estilos.css" />
    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Datos Médicos♥</title>
</head>

<body>
    <header>
        <div class="contenedor">
            <div class="contenedor-texto">
                <div class="texto">
                    <h1 class="nombre">Vida Saludable</h1>
                    <h2 class="profesion">Supera el Covid-19 con nosotros</h2>
                </div>
            </div>
        </div>
    </header>

    <div class="container text-center mt-3">
        <h2 class="text-white rounded p-2" style="background-color: #1e2b38;"> Reprogramación de Cita </h2>
    </div>

    <main class="container my-3">
        <!-- Formulario de actualización -->
        <div class="py-2 px-2 bg-white rounded">
            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
                <div class="row px-3 pt-2 pb-1">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="nombres" class="col-sm-3 col-form-label"><strong>Paciente:</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo "$param_nombres_paciente $param_apellido_paciente" ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cedula" class="col-sm-3 col-form-label"><strong>Cédula:</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $param_cedula_paciente ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correo" class="col-sm-3 col-form-label"><strong>Correo:</strong></label>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $param_correo_paciente ?>"readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-sm-3 col-form-label"><strong>Teléfono:</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $param_telefono_paciente ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="edad" class="col-sm-3 col-form-label"><strong>Edad:</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edad" name="edad" value="<?php echo $param_edad_paciente ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fecha" class="col-sm-3 col-form-label"><strong>Fecha:</strong></label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $param_fecha_cita ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hora" class="col-sm-3 col-form-label"><strong>Hora:</strong></label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo date ('H:i',strtotime($param_hora_cita)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="text-center w-100 py-2 mt-3">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <section class="redes-sociales">
            <div class="contenedor">
                <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </section>
        <div class="fondofooter">
            <div class="contenedor">
                <div class="opcion">
                    <h2>El Hospital</h2>
                    <a href="">Especialidades</a>
                    <a href="">Nuestros médicos</a>
                    <a href="">Acerca de nosotros</a>
                    <a href="">Instalaciones y servicios</a>
                    <a href="">Impacto ambiental</a>
                </div>
                <div class="opcion">
                    <h2>Productos y servicios</h2>
                    <a href=""><img src="./img/laboratorio-medico.png" width="25px" height="25px">Laboratorio</a>
                    <a href=""><img src="./img/doctor.png" width="25px" height="25px"> Imagen</a>
                    <a href=""><img src="./img/prueba-de-covid.png" width="25px" height="25px">
                        Pruebas de covid 19
                    </a>
                </div>
                <div class="opcion">
                    <h2>CONTACTO</h2>
                    <a href="">
                        <img src="./img/contacto.png" width="25px" height="25px"> <b>(+593)</b>
                        960089365
                    </a>
                    <a href="">
                        <img src="./img/contacto.png" width="25px" height="25px"> <b>(+593)</b>
                        985318187
                    </a>
                    <a href="">
                        <img src="./img/contacto.png" width="25px" height="25px"> <b>(+593)</b>
                        960078542
                    </a>
                    <a href="">
                        <img src="./img/correo-electronico.png" width="25px" height="25px">
                        info@clinicmonblue.org.ec
                    </a>
                    <a href="">
                        <img src="./img/pin-de-ubicacion.png" width="25px" height="25px">
                        Rosales Av.Manuel Rendon. Santo Domingo - Ecuador
                    </a>
                </div>
                <div class="opcion">
                    <h2>CLÍNICA MONKEY-BLUE</h2>
                    <a id="imagen2" href="#"><img src="./img/iconoclinica.png" alt=""></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>