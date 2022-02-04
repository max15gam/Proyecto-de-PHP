<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Maximiliano Gambetta">
  <title>Document</title>
  <style>
    *{
      margin: 0;
      padding: 0;
    }

    body{
      background-image: url(img/background.jpg); 
      background-color: black;
      background-repeat: no-repeat;
      background-size: 100%;
    }

    #header{
      text-align: center;
      padding: 50px;
    }

    h1{
      color: white;
    }

    #contenedor{
      margin: 0 auto;
      width: 70%;
      padding: 10px;
      background-image: url(img/contenedor.jpg);
      background-repeat: no-repeat;
      border: groove 2px rgb(196, 195, 195);
      border-radius: 15px;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    } 

    table {
      margin: 0 auto;
    }
    td{
      width: 100px;
      height: 100px;
      border: 1px solid white;
    }


  </style>
  
</head>
<body>
  <div id="header">
    <h1 id="turno"></h1>
  </div>
 

  <div id="contenedor">
    <div style="text-align: center;"><h1 id="ganador"></h1></div>
    <div id="tateti">
      <table>
          <tr>
            <td id="td1" onclick="ejecutar(this.id)"></td>
            <td id="td2" onclick="ejecutar(this.id)"></td>
            <td id="td3" onclick="ejecutar(this.id)"></td>
          </tr>
          <tr>
            <td id="td4" onclick="ejecutar(this.id)"></td>
            <td id="td5" onclick="ejecutar(this.id)"></td>
            <td id="td6" onclick="ejecutar(this.id)"></td>
          </tr>
          <tr>
            <td id="td7" onclick="ejecutar(this.id)"></td>
            <td id="td8" onclick="ejecutar(this.id)"></td>
            <td id="td9" onclick="ejecutar(this.id)"></td>
          </tr>
      </table>
    </div>
  
  </div>
  
<script>

let jugadorUno = "x";
let jugadorDos = "o";
let jugadorActivo = jugadorUno;

ids = [{nombre: "td1", clikeado: false, contenido: ""},{nombre: "td2", clikeado: false, contenido: ""},
{nombre: "td3", clikeado: false, contenido: ""},{nombre: "td4", clikeado: false, contenido: ""},
{nombre: "td5", clikeado: false, contenido: ""},{nombre: "td6", clikeado: false, contenido: ""},
{nombre: "td7", clikeado: false, contenido: ""},{nombre: "td8", clikeado: false, contenido: ""},
{nombre: "td9", clikeado: false, contenido: ""}];
 // creo un array con cada Id, cada vez que uno se clickea cambia su estado a true

document.getElementById("turno").innerHTML = "Turno del jugador uno";

function controlClicks(idControl){

for (let i = 0; i < ids.length; i++) {
  if(idControl === ids[i].nombre){
    if(ids[i].clikeado == false){
      ids[i].clikeado = true;
      ids[i].contenido = jugadorActivo;
      return "no habia sido clickeado antes";
    }
  }
  
}

return "fue clickeado antes";

}

function ocultar() {
  document.getElementById("tateti").style.display = "none";
}

function controlPartida(estado){
  for (let i = 0; i < ids.length; i++) {
  
  if(ids[0].contenido === "x" && ids[1].contenido === "x" && ids[2].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 800);
    return true;
  }

  if(ids[3].contenido === "x" && ids[4].contenido === "x" && ids[5].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[6].contenido === "x" && ids[7].contenido === "x" && ids[8].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  



  if(ids[0].contenido === "x" && ids[3].contenido === "x" && ids[6].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[1].contenido === "x" && ids[4].contenido === "x" && ids[7].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[2].contenido === "x" && ids[5].contenido === "x" && ids[8].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }



  if(ids[0].contenido === "x" && ids[4].contenido === "x" && ids[8].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[2].contenido === "x" && ids[4].contenido === "x" && ids[6].contenido === "x"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR UNO!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }




// LA o





  if(ids[0].contenido === "o" && ids[1].contenido === "o" && ids[2].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[3].contenido === "o" && ids[4].contenido === "o" && ids[5].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[6].contenido === "o" && ids[7].contenido === "o" && ids[8].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  



  if(ids[0].contenido === "o" && ids[3].contenido === "o" && ids[6].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[1].contenido === "o" && ids[4].contenido === "o" && ids[7].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[2].contenido === "o" && ids[5].contenido === "o" && ids[8].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }



  if(ids[0].contenido === "o" && ids[4].contenido === "o" && ids[8].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }

  if(ids[2].contenido === "o" && ids[4].contenido === "o" && ids[6].contenido === "o"){
    <?php $ganador = "¡EL GANADOR ES EL JUGADOR DOS!"; ?>
    var ganador=<?php echo json_encode($ganador); ?>;
    document.getElementById("ganador").innerHTML = ganador ;
    setTimeout(ocultar, 1000);
    return true;
  }



  return false;
  
  
}
}




function ejecutar(idClickeado){

  
let controlIdClickeados = controlClicks(idClickeado); // funcion para controlar los casilleros clickeados


if(controlIdClickeados === "fue clickeado antes"){
  return;
} // si fue clickeado retorna, no sucede nada

let controlGanador = controlPartida();


if(jugadorActivo==="x"){
  <?php $imagenX = '<img src="img/cruz.png" alt="">'; ?>
  var something=<?php echo json_encode($imagenX); ?>;
  document.getElementById(idClickeado).innerHTML = something;
  jugadorActivo = jugadorDos;
  document.getElementById("turno").innerHTML = "Turno del jugador dos";
  if(controlGanador){
  <?php $mensaje = "Felicidades!"; ?>
  var cumplido=<?php echo json_encode($mensaje); ?>;
  document.getElementById("turno").innerHTML = cumplido;
  return;
}//si hay un ganador el juego no continúa
  return;
}

if(jugadorActivo==="o"){
  <?php $imagenO = '<img src="img/circulo.png" alt="">'; ?>
  var something=<?php echo json_encode($imagenO); ?>;
  document.getElementById(idClickeado).innerHTML = something;
  jugadorActivo = jugadorUno;
  document.getElementById("turno").innerHTML = "Turno del jugador uno";
  if(controlGanador){
  <?php $mensaje = "Felicidades!"; ?>
  var cumplido=<?php echo json_encode($mensaje); ?>;
  document.getElementById("turno").innerHTML = cumplido;
  return;
}//si hay un ganador el juego no continúa
  return;
}




}



</script>



</body>
</html>