<?php

include("../include/db.php");
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM cita WHERE idCita  = '$id'";
  $resul = mysqli_query($conexion, $query);


  if (mysqli_num_rows($resul) == 1) {
    $row = mysqli_fetch_array($resul); //tomasme todo el resultado de la consulta
    $id = $row['idCita'];
    $fecha = $row['fecha']; //especificamos que resultado 
    $hora = $row['hora']; //especificamos que resultado
    $paciente = $row['idPaciente'];
    $medico = $row['idMedico'];
  }
}


if (isset($_POST['update'])) { //en caso que exista el metodo updatte por quiere actualizar
  $id = $_GET['id'];
  $fecha = $_POST['fecha'];
  $hora = $_POST['hora'];
  $medico = $_POST['medico'];
  $paciente = $_POST['paciente'];

  $query = "UPDATE cita set fecha = '$fecha', hora = '$hora', idMedico = '$medico', idPaciente  = '$paciente' WHERE idCita = '$id' ";
  $resul = mysqli_query($conexion, $query);
  header("Location: citas_1.php");
}



?>

<?php include("../include/header.php"); ?>

<body>
  <div class="box-area">
  <div class="cerrar">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
              <h5 class="text-white h4">Clinica</h5>
              <span class="text-muted">Editar datos</span>
            </div>
          </div>
          <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </div>
          </nav>
    </div>
    <div class="banner-area">
      <h2>this is banner</h2>
    </div>
  </div>
  <div class="container p-4 ">
    <div class="row">
      <div class="col-md-4 mx-auto">
        <div class="card card-body prueba05">
          <!-- mandando los datos a edit.php y recibo los datos mendiante el metodo post-->
          <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
              <!-- value para que muestre el valor de la variable a modificar -->
              <input name="id" type="text" class="form-control" value="<?php echo $id; ?>" placeholder="Editar C.I"><br>
              <input name="fecha" type="date" class="form-control" value="<?php echo $fecha; ?>" placeholder="Editar fecha"><br>
              <input name="hora" type="time" class="form-control" value="<?php echo $hora; ?>" placeholder="Editar hora"><br>
              <input name="paciente" type="text" class="form-control" value="<?php echo $paciente; ?>" placeholder="Editar paciente"><br>
              <input name="medico" type="text" class="form-control" value="<?php echo $medico; ?>" placeholder="Editar medico"><br>
            </div>
            <button class="btn btn-success" name="update">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include("../include/footer.php"); ?>
