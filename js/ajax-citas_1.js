var btn_cargar = document.getElementById("btn_cargar_usuarios"),
  error_box = document.getElementById("error_box"),
  tabla1 = document.getElementById("tabla"),
  formulario = document.getElementById("formulario"),
  loader = document.getElementById("loader");
  var usuario_id,usuario_fecha, usuario_pasiente, usuario_hora, usuario_medico;
  
  function cargarUusarios() {
    //PARA QUE VUELVA A CAGAR DE NUEVO TODO DEL DIV TABLA
    tabla1.innerHTML =
    "<tr><th>Facha</th><th>Hora</th><th>Cédula Paciente</th><th>Cédula Medico</th><th>Aciones</th></tr>";
    var peticion = new XMLHttpRequest(); //Realizando una peticion
    peticion.open("GET", "../php_cita/leer-citas.php");
    loader.classList.add("active"); // para la rueda de carga

  peticion.onload = function () {
  
    //var datos = peticion.responseText;//LOS DATOS SOLO SON TEXTO
    var datos = JSON.parse(peticion.responseText); //TRANFORMADO JSON
    console.log("datos", datos);
    //PARA QUE MUESTRE UN ERROR SI LA CONEXION ESTA MAL
    // $.ajax({url:"../php/edit.php",method: "post",data: {emps: JSON.stringify(datos)},success: function(res){
    //     console.log("Sera que funciono"+res);
    // }});
    if (datos.error) {
      //accediendo a los datos del php
      error_box.classList.add("active");
      console.log("error");
    } else {
      for (let i = 0; i < datos.length; i++) {
        var elemento = document.createElement("tr");
        elemento.innerHTML += "<td>" + datos[i].fecha + "</td>";
        elemento.innerHTML += "<td>" + datos[i].hora + "</td>";
        elemento.innerHTML += "<td>" + datos[i].medico + "</td>";
        elemento.innerHTML += "<td>" + datos[i].paciente + "</td>";
        elemento.innerHTML += `<td><a href="edit.php?id=${datos[i].cita}" name="fecha1" class="btn-1 btn1 btn-secondary" style="background: #6c757d;" ><i class="fas fa-marker"></i></a>
                                    <a href="#" class="btn-1 btn1 btn-danger" style="background: #979A9A ;"><i class="far fa-trash-alt"></i></a></td>`;
        tabla1.appendChild(elemento);
      }
    }
    console.log(datos + "dads");
  };
  console.log('hpla');
  peticion.onreadystatechange = function () {
    if (peticion.readyState == 4 && peticion.status == 200) {
      // si lo mostrasdo esta finalizo 2 = peticion resivida 3 = peticion procesada 4 = petcion finaalizada
      // 200 =  para que salga el error 404
      loader.classList.remove("active"); //PARA QUITAR EL LOADER
    }
  };

  peticion.send(); //NUNCA OLVIDAR DE UBICAR ESA PARTE
}

function agregarUsuarios() {
  usuario_fecha = formulario.fecha.value.trim(); //PARA QUITAR LOS ESPACIOS DEL FORMULARIO
  usuario_pasiente = parseInt(formulario.pasiente.value.trim());
  usuario_hora = formulario.hora.value.trim();
  usuario_medico = parseInt(formulario.medico.value.trim());

  console.log(formulario_valido());
  if (formulario_valido()) {
 
  } else {
    error_box.classList.add("active");
    error_box.innerHTML = "Por favor complete el formulario correctamente";
  }
}

btn_cargar.addEventListener("click", function () {
  cargarUusarios();
});

formulario.addEventListener("submit", function (e) {
  //DE DONDE SACO EL fecha FORMULARIO?
  agregarUsuarios(e);
});

function formulario_valido() {
  if (usuario_fecha == "") {
    return false;
  } else if (usuario_hora == "") {
    return false;
  } else if (isNaN(usuario_pasiente)) {
    return false;
  } else if (isNaN(usuario_medico)) {
    return false;
  }
console.log('Pruebas de');
  return true;
}
