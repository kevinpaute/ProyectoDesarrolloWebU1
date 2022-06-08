<?php include("../include/db.php");?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600" rel="stylesheet"> 
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../css/estilos2.css" rel="stylesheet">
    <link href="css/estilos2.css" rel="stylesheet">

  </head>
  <body>
   
    <div class="cerrar">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
              <h5 class="text-white h4">Clinica</h5>
              <span class="text-muted">Ingreso de datos.</span>
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
    <div>
      <div class="contenedor">
        <header>
          <h1>Tabla de Usuarios</h1>
          <div>
            <button id="btn_cargar_usuarios" class="btn-1 active" >Cargar Citas</button>
          </div>
        </header>
        <main>
          <form action="agregarSQL.php" method="post" id="formulario" class="formulario">
            <input type="date" name="fecha" id="fecha" placeholder="Fecha">
            <input type="time" name="hora" id="hora" placeholder="Hora">
            <input type="number" name="medico" id="medico" placeholder="ID Medico">
            <input type="number" name="pasiente" id="pasiente" placeholder="ID Paciente">
            <button type="submit" class="btn-1">Agregar</button>
          </form>
          <div class="error_box" id="error_box">
            <p>Se ha producido un error.</p>
          </div>
          <table id="tabla" class="tabla">
            <tr>
              <th>Facha</th>
              <th>Hora</th>
              <th>Cédula Paciente</th>
              <th>Cédula Medico</th>
            </tr>
          </table>
      
          <div class="loader" id="loader"></div>
        </main>
      </div>
    </div>
    <script src="../js/ajax-citas_1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>



  </body>
</html>