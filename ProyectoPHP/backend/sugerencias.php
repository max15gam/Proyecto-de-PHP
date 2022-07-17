<?php 
session_start();
include("../configuracion/configuracion.php");



$conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sqlVehiculos = "SELECT * FROM vehiculos;"; //me traigo los vehiculos

$mysqlPDO = $conexion->prepare($sqlVehiculos);
$respuesta = $mysqlPDO->execute();

$listaVehiculos = $mysqlPDO->fetchAll();

//con la variable session del id del vehiculo mediante un foreach hago que sugiera otros vehiculos de la misma marca
foreach ($listaVehiculos as $item) {
  if($item['idVehiculo'] === $_SESSION['idVehiculo']){
    $marcaVehiculo = $item['marca'];
  }
  
}

$idDelAuto = $_SESSION['idVehiculo'];

/*con el id y la marca hago la consulta en procura de los otros vehiculos de la misma marca PERO exceptuando
el vehiculo que no estaba disponible*/
$sqlVehiculosPorMarca = "SELECT * 
                        FROM vehiculos 
                        WHERE marca = '$marcaVehiculo' AND NOT idVehiculo = '$idDelAuto';";

$mysqlPDO = $conexion->prepare($sqlVehiculosPorMarca);
$respuesta = $mysqlPDO->execute();

$listaVehiculosPorMarca = $mysqlPDO->fetchAll();







//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------GENERAR UN NUEVO ALQUILER----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------


$idVehiculo = "";
$fechaDesde = "";
$FechaHasta = "";
$precioPorDia = "";


//capturo campos para generar un nuevo alquiler

if(isset($_POST['idCoche'])){
  $idVehiculo = $_POST['idCoche'];
  foreach ($listaVehiculos as $clave) {
    if($clave['idVehiculo'] === $idVehiculo){
      $precioPorDia = $clave['precio'];
    }
  }
  
  
}
    

if(isset($_POST['registroFechaDesdeAlquiler'])){

  $fechaDesde = $_POST['registroFechaDesdeAlquiler'];
  echo $fechaDesde;
  
}

if(isset($_POST['registroFechaHastaAlquiler'])){

  $fechaHasta = $_POST['registroFechaHastaAlquiler'];
  echo $fechaHasta;
  
}


if( !empty($fechaDesde) || !empty($fechaHasta) || !empty($idVehiculo) || !empty($precioPorDia) ){

      $objAlquiler = new Alquiler();

      $datos = ["fechaInicio"=>$fechaDesde,"fechaFin"=>$fechaHasta,"estado"=>"activado","idCliente"=>$_SESSION['id'],"idUsuario"=>"3","idVehiculo"=>$idVehiculo,
      "precioTotal"=>$precioPorDia];

      $objAlquiler->constructor($datos);

      $objAlquiler->crearAlquiler();

}








if(isset($_POST['retorno'])){

  header('Location: interfaz_cliente.php');
  exit();
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Automotora Gambetta</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../web/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../web/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../web/css/estilos.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style>
    *{
      margin: 0;
      paddinh: 0;
    }

    nav{
      position: fixed !important;
      background-image: url(../web/img/header.jpg) !important;
    }

    footer{
      
      background-image: url(../web/img/header.jpg) !important;
    }

    /* .container{
      margin: 0px !important;
    } */

    strong {
      font-size: 2rem;
    }

    .alturaMaximaVehiculos{
      min-width: 12em;
      max-height: 12em;
    }



    
  </style>
  
</head>
<body>

<div>

  <div class="row">
      <div class="col s12 center">
        <form action="sugerencias.php" method="post">
          <input type="hidden" name="retorno" value="retorno">
          <button type="submit" class="waves-effect waves-light btn black">Volver</button>
        </form>
      </div>

      <div class="col s12 center">
        <h1>Lo sentimos, el auto no está disponible o las fechas no son válidas</h1>
        <h2>También te podría interesar:</h2>
      </div>

    <div class="col s12">

        <?php  foreach ($listaVehiculosPorMarca as $item) {   
                  ?>


            <div class="col s6 m4">

                  <div class="card hoverable modal-trigger" onClick="setearID('<?=$item['idVehiculo']?>')" id='<?=$item['idVehiculo']?>' data-target="modalReserva">
                    <div class="card-image waves-effect waves-block waves-light">
                    <form action="interfaz_cliente.php" method="POST">
                    <input type="hidden" name="idDelAuto" value="<?=$item['idVehiculo']?>">
                    <img type="submit" class="responsive-img alturaMaximaVehiculos" src="../web/img/automoviles/<?=$item['imagen'] ?>">
                    </form>
                    </div>
                    <div class="card-content center">
                      <strong class="black-text text-lighten-3"><?=$item['modelo'] ?></strong>
                      <a class="btn-floating btn-large pulse grey right"><i class="material-icons">check_circle</i></a>
                    </div>
                  </div>
            </div>


                <?php  }
                      ?>   

              </div>

          </div>

        </div>
          

        </div>
  

  
 



  </div>




  <div id="modalReserva" class="modal" >
  <div class="modal-content row">

    <form class="col s12" method="POST" action="interfaz_cliente.php">
      <div id="hiddenIdCoche"></div>

      <div class="col s12">
        <div class="input-field col s12">
          <input id="alquilerDesde" type="text" class="datepicker" name="registroFechaDesdeAlquiler" required>
          <label for="alquilerDesde">Desde</label>
        </div>
        <div class="input-field col s12">
          <input id="alquilerHasta" type="text" class="datepicker" name="registroFechaHastaAlquiler" required>
          <label for="alquilerHasta">Hasta</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light grey" type="submit">Ingresar
        <i class="material-icons right">send</i>
      </button> 
      
    </form>
    
    
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
  </div>
</div>







  <!-- comienza el footer -->

  <footer class="page-footer">
          
          <div class="footer-copyright" >
            <div class="container row">
              
              <div class="col s4">
                <p> © 2014 Copyright Automotora Gambetta</p>
              </div>
             
            
            </div>
          </div>
  </footer>


  <!--  Scripts-->
 
  <script src="../web/js/jquery-2.1.1.js"></script>
  <script>
    let idModal;
    function setearID(id){
      $('#modalReserva #hiddenIdCoche').html(
        "<input type='hidden' id='#idHidden' name='idCoche' value='"+id+"' />"
      );
      //console.log(id);
    }
  $(document).ready(function(){
    $('.carousel').carousel();
    $('.modal').modal();
    $('input#input_text, textarea#textarea2').characterCounter();
    $('select').formSelect();
    $(".dropdown-trigger").dropdown();
    $('.datepicker').datepicker({
    format: 'yyyy-mm-dd' });
    
  });

  

  </script>
  <script src="../web/js/materialize.js"></script>
  <script src="../web/js/init.js"></script>
  <script src="../web/js/scripts_cliente.js"></script>

  



  </body>


  
</html>
