<?php
    require_once('conexion.php');

    # Validar que si se envian los datos 
    # Usamos el Metodo GET, ya uqe estamos trabajando por URL
    if(isset($_GET['id']) && !empty(trim($_GET['id']))){
        // cREACIÓN DE LA CONSULTA
        $query = 'SELECT * FROM paciente WHERE idUsuario=?';

        // Preparar la sentencia
        if($stmt = $conn -> prepare($query)){
            $stmt -> bind_param('i', $_GET['id']);
            // Ejecución de la entencia
            if($stmt -> execute()){
                $result = $stmt -> get_result();
                if($result -> num_rows == 1){
                    $row = $result -> fetch_array(MYSQLI_ASSOC);
                    $nombres = $row['nombres'];
                    $apellidoPaterno = $row['apellido_paterno'];
                    $apellidoMaterno = $row['apellido_materno'];
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
        $stmt -> close();
        $conn -> close();
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
    <link rel="stylesheet" href="styles.css">
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

        .carta{
            /* width: 100%; */
            display: flex;
            flex-direction: row;
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

        .citas{
            width: 50vw;
            min-width: 300px;
        }

        .img{
            margin-right: 1rem;
        }
    </style>
        <h2>Datos Cliente</h2>
    
    <div class="contenedor">
        <div class="carta carta-hero">
            <div class="img">
              <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>';?>
            </div>
            <div class="info">
              <div class="">
                <h5 ><?php echo $nombre.' '.$apellido; ?></h5>
                <hr>
                <p ><?php echo $cedula ?></p>
                <p ><small class="text-muted"><?php echo $telefono ?></small></p>
              </div>
            </div>
        </div>
        <div class="carta citas">
            <div class="info">
              <div class="">
                
                <h5 >SUS CITAS</h5>
                <hr>
                <p ><?php echo $cedula ?></p>
                <p ><small class="text-muted"><?php echo $telefono ?></small></p>
              </div>
            </div>
        </div>
    </div>
    <p><a href="index.php" class="btn btn-primary">Atrás</a></p>
</body>
</html>