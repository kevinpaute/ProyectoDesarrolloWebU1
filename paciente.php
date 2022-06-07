<?php
    require_once('conexion.php');

    # Validar que si se envian los datos 
    # Usamos el Metodo GET, ya uqe estamos trabajando por URL
    if(isset($_GET['id']) && !empty(trim($_GET['id']))){
        // cREACIÓN DE LA CONSULTA
        $query = 'SELECT * FROM paciente WHERE idPaciente=?';

        // Preparar la sentencia
        if($stmt = $conn -> prepare($query)){
            $stmt -> bind_param('i', $_GET['id']);
            // Ejecución de la entencia
            if($stmt -> execute()){
                $result = $stmt -> get_result();
                if($result -> num_rows == 1){
                    $id = $_GET['id'];
                    $row = $result -> fetch_array(MYSQLI_ASSOC);
                    $nombres = $row['nombres'];
                    $apellidoPaterno = $row['apellido_paterno'];
                    $apellidoMaterno = $row['apellido_materno'];
                    $cedula = $row['cedula'];
                    $correo = $row['correo'];
                    $fNacimiento = $row['fNacimiento'];
                    $edad = $row['edad'];
                    $telefono = $row['telefono'];
                    $ciudad = $row['ciudad'];
                    $direccion = $row['direccion'];
                    $foto = $row['foto'];
                    $user = $row['user'];
                    $password = $row['password'];
                }else{
                    echo 'Error, No existen los datos';
                    exit();
                }
            }else{
                echo 'Error! Revise la conexión con al base de datos';
                exit();
            }
        }
        // $stmt -> close();
        // $conn -> close();

        // CONSULTA PARA LA CITA

        $query = 'SELECT cita.*, medico.* FROM `cita` INNER JOIN paciente ON cita.idPaciente = paciente.idPaciente INNER JOIN medico ON cita.idMedico = medico.idMedico;';
        

        // Preparar la sentencia
        $result = $conn->query($query);
        if($result -> num_rows > 0){
            $id = $_GET['id'];
            while($row = $result -> fetch_assoc()){
                if($row['idPaciente'] == $id){
                    $idMedico = $row['idMedico'];
                    $nombresMedico = $row['nombres'];
                    $apellidoMedico = $row['apellido_paterno'];
                    $correoMedico = $row['correo'];
                    // Para la CITA
                    $idCita = $row['idCita'];
                    $fecha = $row['fecha'];
                    $hora = $row['hora'];
                }
            }
        }else{
            echo 'Error, No existen los datos';
            exit();
        }

    } else{
        echo 'Error intente mas tarde';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <title>DATOS DEL CLIENTE</title>
</head>
<body>
    <style>
        img{
            width: 10vw;
            min-width: 140px;
        }

        .contenedor{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .contect{
            display: flex;
            flex-direction: row;
        }

        .carta{
            /* width: 100%; */
            display: flex;
            flex-direction: column;
            /* justify-content: space-between;  */
            border: 1px solid rgba(0, 0, 0, 0.344);
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem;
        }

        .carta-hero{
            width: 50vw;
            min-width: 300px;
        }

        .container{ 
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .citas{
            width: 30vw;
            min-width: 300px;
        }

        .til{
            text-align: center;
        }

        .img{
            margin-right: 1rem;
        }

        .info{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;

        }

        .micro{
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            /* justify-content: center; */
        }

        .micro div{
            display: flex;
            flex-direction: column;
        }

        strong{
            font-size: 1.2rem;
        }

        small{
            font-size: 1.2rem;
        }
    </style>
        <h2>Datos Cliente</h2>
    
    <div class="contenedor">
        <div class="carta carta-hero">
            <div class="til">
                <h2 >SUS DATOS</h5>
            </div>
            <hr>
            <div class="info">
                <div class="img">
                  <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($foto).'"/>';?>
                </div> 
                <div class="micro">
                    <h4><?php echo 'name: '.$nombres . ' '. $apellidoPaterno.' '.$apellidoMaterno .''?></h4>
                    <p><small class="text-muted"><?php echo 'adress: '.$direccion .''?></small></p>
                    <p ><small class="text-muted"><?php echo 'email: '.$correo.'' ?></small></p>
                    <p ><small class="text-muted"><?php echo 'ci: '.$cedula.''?></small></p>
                </div>
                <div class="micro">
                    <p><small class="text-muted"><?php echo 'city: '.$ciudad .''?></small></p>
                    <p ><small class="text-muted"><?php echo 'cell: '.$telefono .''?></small></p>
                    <p ><small class="text-muted"><?php echo 'yaers: '.$edad.' años'?></small></p>
                </div>
            </div>
            
        </div>
        <div class="carta citas">
            <div class="til">
                <h2 >SUS CITAS</h5>
            </div>
            <hr>
            <div class="info">
              <div class="micro">
                  <div>
                    <label for="" ><h4>Con el medico</h4> </label>
                    <p><small class="text-muted"><?php echo $nombresMedico . ' '. $apellidoMedico  ?></small></p>
                  </div>
                  <div>
                    <label for=""><h4>Email</h4></label>
                    <p ><small class="text-muted"><?php echo $correoMedico ?></small></p>
                  </div>
              </div>
              <div class="micro">
                  <div>
                    <label for="" ><h4>Fecha</h4></label>
                    <p ><small class="text-muted"><?php echo $fecha ?></small></p>
                  </div>
                  <div>
                    <label for=""><h4>Hora</h4></label>
                    <p ><small class="text-muted"><?php echo $hora ?></small></p>
                  </div>
              </div>
            </div>
        </div>
    </div>
    <p><a href="index.php" class="btn btn-primary">Atrás</a></p>
</body>
</html>