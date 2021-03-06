<?php
//si no hay sesión se redirige al login
session_start();
if (!$_SESSION) {
  header("location:login.html");
}
//Instanciamos la conexión
require_once "conexion.php";






//Se obtienen los datos de la sesión, es decir los datos del médico logeado
$id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];

//Consultamos los datos del médico según su ID almacenado en Sesión
//Se detalla la consulta
$consulta = "SELECT * FROM direccion WHERE idDireccion = ?";
if ($stmt = $conn->prepare($consulta)) {
  //Se establecen los parámetros
  //En este caso la i representa que se va a pasar un dato entero 
  $stmt->bind_param("i", $id);
  //Se ejecuta la sentencia con los parámetros establecidos
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    //Se recorre el resultado y se almacena en variables para poder ocuparlas en el HTML
    if ($result->num_rows == 1) { 
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $param_id_direccion = $row["idDireccion"];
      $param_id_user = $row["user"];
      $param_cedula_direccion = $row["cedula"];
      $param_nombre_direccion = $row["nombres"];
      $param_apellido_direccion = $row["apellido_paterno"];
      $param_apellido_materno_direccion = $row["apellido_materno"];
      $param_correo_direccion = $row["correo"];
      $param_roles_direccion = $row["roles"];
      $param_telefono_direccion = $row["telefono"];
      $param_ciduad_direccion = $row["ciudad"];
      $param_foto_direccion = $row["foto"];
      $param_password_direccion = $row["password"];

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















//Consultamos los datos de las citas según el ID del médico almacenado en Sesión
//Se detalla la consulta
$consulta2 = "SELECT idCita,cita.fecha AS fecha,cita.hora AS hora,medico.nombres AS nombreM ,medico.cedula AS cedeulaA,paciente.nombres AS nombreP,paciente.cedula AS cedulaP FROM cita 
INNER JOIN medico ON cita.idMedico = medico.idMedico
INNER JOIN paciente ON cita.idPaciente = paciente.idPaciente";

$result2 = $conn -> query($consulta2);


//Proceso de actualización de información
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Se valida que los campos a actualizar no estén vacíos la función es isset, puedes revisar mas en la documentación de PHP
  if (isset($_POST['correo']) && isset($_POST['telefono']) && isset($_POST['ciudad'])) {
    //Se detalla la consulta
    $sql = "UPDATE direccion SET correo=?, telefono=?, ciudad=?, password=? WHERE idDireccion=?";
    //Se prepara la consulta
    if ($stnt = $conn->prepare($sql)) {
      //Se establecen los parámetros
      //sssi significa que se van a pasar 5 parámetros de tipos string y 1 entero representado por la i de integer que es el id
      $stnt->bind_param("ssssi", $_POST['correo'], $_POST['telefono'], $_POST['ciudad'], $_POST['password'], $id);
      //Se ejecuta la sentencia
      if ($stnt->execute()) {
        //Si todo sale bien se recarga la página
        header("location: secretarias.php");
        exit();
      } else {
        //Caso contrario muestra un mensaje de error
        echo "Error, intente de nuevo";
      }
      //Se cierra el stament de preparación que nos ayudó a ejecutar la solicitud
      $stnt->close();
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
    <h2 class="text-white rounded p-2" style="background-color: #1e2b38;"> Bienvenido <?php echo "$nombre   $param_apellido_direccion" ?></h2>
  </div>

  <main>
    <!-- SECCION MÉDICO PRINCIPAL-->
    <div class="container mb-3">
      <div class="w-100">
        <div class="w-100">
          <?php
          if ($param_foto_direccion != null) {
            echo "<img class='d-block mx-auto my-3 rounded-circle' src='data:image/jpeg; base64," . base64_encode($param_foto_direccion) . "'style='width:250px; height:250px'>";
          } else {
            echo "<div class='bg-white p-2 my-3 text-center'>
                    <h2 >No hay foto</h2>
                    <p>Subir imagen. Máximo 100KB.</p>
                    <form enctype='multipart/form-data' action='upload.php' method='post'>
                      <label>Upload the image file:</label><br />
                      <input name='userImage' type='file' />
                      <input type='submit' value='Upload' />
                    </form>
                  </div>";
          }

          ?>
        </div>
      </div>
      <div class="d-flex w-100 justify-content-center bg-white rounded p-2">
        <div class="text-center w-100" style="background-color: #1e2b38;">
          <h5 class="text-white mt-2">
            <i class="fa fa-user"></i>
            <?php echo "$param_nombre_direccion $param_apellido_direccion" ?>
          </h5>
        </div>
        <div class="text-center w-100" style="background-color: #1e2b38;">
          <h5 class="text-white mt-2">
            <i class="fa fa-briefcase-medical"></i>
            <?php echo  $param_roles_direccion ?>
          </h5>
        </div>
        <div class="text-center w-100" style="background-color: #1e2b38;">
          <h5 class="text-white mt-2">
            <i class="fa fa-id-badge"></i>
            <?php echo $param_cedula_direccion ?>
          </h5>
        </div>
        <div class="text-center w-100" style="background-color: #1e2b38;">
          <h5 class="text-white mt-2">
            <i class="fa fa-envelope"></i>
            <?php echo $param_correo_direccion ?>
          </h5>
        </div>
      </div>
    </div>

    <!-- Lista deplegable -->
    <div class="container mt-3 mb-3">
      <div class="accordion" id="accordionExample">
        <!-- Sección de información del médico a actualizar -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Registrar
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="container">
                <h3 class="text-white rounded p-2" style="background-color: #1e2b38;">Registrar Citas</h3>
                <div class="py-2 border rounded">
                  <form method="post" action="zz.php">
                    <div class="row px-3 pt-2 pb-1">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label for="nombres" class="col-sm-3 col-form-label"><strong>Fecha:</strong></label>
                          <div class="col-sm-7">
                            <input type="date" class="form-control" id="nombres" name="fecha">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="apellidos" class="col-sm-3 col-form-label"><strong>Hora:</strong></label>
                          <div class="col-sm-7">
                            <input type="time" class="form-control" id="apellidos" name="hora">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cedula" class="col-sm-3 col-form-label"><strong>C.I. Paciente:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="cedula" name="cedula" >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cedula" class="col-sm-3 col-form-label"><strong>C.I. Doctor:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="cedula" name="cedulaMedico" >
                          </div>
                        </div>
                      </div>
                      <div class="text-center w-100 py-2">
                        <button type="submit" name="submit2" class="btn btn-primary">Registrar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>



        





        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              Actualizar Información
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="container">
                <h3 class="text-white rounded p-2" style="background-color: #1e2b38;">Información del Médico</h3>
                <div class="py-2 border rounded">
                  <form method="post" action="<?php echo $_SERVER["REQUEST_URI"] ?>">
                    <div class="row px-3 pt-2 pb-1">
                      <div class="col-sm-6">
                        <div class="form-group row">
                          <label for="nombres" class="col-sm-3 col-form-label"><strong>Nombres:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $param_nombre_direccion ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="apellidos" class="col-sm-3 col-form-label"><strong>Apellidos:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo "$param_apellido_direccion $param_apellido_materno_direccion" ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cedula" class="col-sm-3 col-form-label"><strong>Cédula:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $param_cedula_direccion ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="correo" class="col-sm-3 col-form-label"><strong>Correo:</strong></label>
                          <div class="col-sm-7">
                            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $param_correo_direccion ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="telefono" class="col-sm-3 col-form-label"><strong>Teléfono:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $param_telefono_direccion ?>">
                          </div>
                        </div>
                        <!-- <div class="form-group row">
                          <label for="fnacimiento" class="col-sm-3 col-form-label"><strong>F. de Nacimiento:</strong></label>
                          <div class="col-sm-7">
                            <input type="date" class="form-control" id="fnacimiento" name="fnacimiento" value="<?php echo $param_fnacimiento_direccion ?>" readonly>
                          </div>
                        </div> -->
                      </div>
                      <div class="col-sm-6">
                        <!-- <div class="form-group row">
                          <label for="edad" class="col-sm-3 col-form-label"><strong>Edad:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="edad" name="edad" value="<?php echo $param_edad_direccion ?>" readonly>
                          </div>
                        </div> -->
                        <!-- <div class="form-group row">
                          <label for="especialidad" class="col-sm-3 col-form-label"><strong>Especialidad:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?php echo $param_nombre_especialidad ?>" readonly>
                          </div>
                        </div> -->
                        <div class="form-group row">
                          <label for="ciudad" class="col-sm-3 col-form-label"><strong>Ciudad:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo  $param_ciduad_direccion ?>">
                          </div>
                        </div>
                        <!-- <div class="form-group row">
                          <label for="direccion" class="col-sm-3 col-form-label"><strong>Dirección:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $param_direccion_direccion ?>">
                          </div>
                        </div> -->
                        <div class="form-group row">
                          <label for="usuario" class="col-sm-3 col-form-label"><strong>Usuario:</strong></label>
                          <div class="col-sm-7">
                            <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $param_id_user ?>" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="password" class="col-sm-3 col-form-label"><strong>Password:</strong></label>
                          <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $param_password_direccion ?>">
                          </div>
                        </div>
                      </div>
                      <div class="text-center w-100 py-2">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>




       
          
        <!-- Sección de las citas -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Mostrar Citas
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="container">
                <h3 class="text-white rounded p-2" style="background-color: #1e2b38;">Citas</h3>
                <div class="py-2 px-3 border rounded">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Nombre Medico</th>
                        <th scope="col">Cédula Medico</th>
                        <th scope="col">Nombre Paciente</th>
                        <th scope="col">Cédula Paciente</th>
                        <th scope="col" colspan="2">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspAcciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      //Se recorre el resultado de la sentencia SQL realizada en forma de ciclo repetitivo
                      if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                          echo "<tr class='odd'>";
                          echo "<td >" . $row['fecha'] . "</td>";
                          echo "<td >" . date('H:i', strtotime($row['hora'])) . "</td>";
                          echo "<td >" . $row['nombreM'] . "</td>";
                          echo "<td >" . $row['cedeulaA'] . "</td>";
                          echo "<td >" . $row['nombreP'] . "</td>";
                          echo "<td >" . $row['cedulaP'] . "</td>";
                          
                          echo "<td><a href='secre_actualizarCita.php? id=" . $row['idCita'] . "' class='btn btn-primary'><i class='fa fa-calendar-check me-2'></i>Reprogramar</a></td>";
                          echo "<td><a href='secretariaCancelarCita.php? id=" . $row['idCita'] . "' class='btn btn-danger'><i class='fa fa-trash me-2'></i>Eliminar</a></td>";
                          echo "<td >";
                        }
                        $result->free();
                      } else {
                        echo "<p><em>No existen datos registrados</p>";
                      }
                      echo "</td>";
                      echo "</tr>";
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
          <a href=""><img src="./img/laboratorio-direccion.png" width="25px" height="25px">Laboratorio</a>
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