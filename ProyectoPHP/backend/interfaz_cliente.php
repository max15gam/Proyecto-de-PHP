<?php 
session_start();

// contengo el error si se intenta recargar la página o al recargar la página principal, ya que la sesión expira
if(!isset($_SESSION['usuario']) && empty($_SESSION['usuario']) || $_SESSION['documento_o_tipoUsuario'] === "administrador"
  || $_SESSION['documento_o_tipoUsuario'] === "encargado" || $_SESSION['documento_o_tipoUsuario'] === "vendedor"  ) {
  echo "La sesión expiró, por favor inicie sesíon";
  die();
}




//cierro sesión
if( isset($_POST['txtCerrarSesion1']) || isset($_POST['txtCerrarSesion2'])){
  
  foreach($_SESSION as $i => $v){
    unset($_SESSION[$i]);
  }

  header('Location: ../index.php');
  exit();
  
  
}

include("../configuracion/configuracion.php");
require_once("../modelos/generico.php");



    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();


    // Listo vehiculos por cada marca para ser mostrados en distintos divs para una mejor experiencia de usuario

    $bmw = array();

    foreach ($listaVehiculos as $itemBmw) {
        if($itemBmw['marca'] === "bmw"){
          array_push($bmw,$itemBmw);
        }
        
    }



    $ford = array();

    foreach ($listaVehiculos as $itemFord) {
        if($itemFord['marca'] === "ford"){
          array_push($ford,$itemFord);
        }
        
    }



    $toyota = array();

    foreach ($listaVehiculos as $itemToyota) {
        if($itemToyota['marca'] === "toyota"){
          array_push($toyota,$itemToyota);
        }
        
    }



    $volkswagen = array();

    foreach ($listaVehiculos as $itemVolkswagen) {
        if($itemVolkswagen['marca'] === "volkswagen"){
          array_push($volkswagen,$itemVolkswagen);
        }
        
    }


    $mitsubishi = array();

    foreach ($listaVehiculos as $itemMitsubishi) {
        if($itemMitsubishi['marca'] === "mitsubishi"){
          array_push($mitsubishi,$itemMitsubishi);
        }
        
    }

    $newHolland = array();

    foreach ($listaVehiculos as $itemNewHolland) {
        if($itemNewHolland['marca'] === "newHolland"){
          array_push($newHolland,$itemNewHolland);
        }
        
    }



    


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
      
      
    }

    if(isset($_POST['registroFechaHastaAlquiler'])){

      $fechaHasta = $_POST['registroFechaHastaAlquiler'];
      
      
    }

    
    if( !empty($fechaDesde) || !empty($fechaHasta) || !empty($idVehiculo) || !empty($precioPorDia) ){

          $objAlquiler = new Alquiler();

          $datos = ["fechaInicio"=>$fechaDesde,"fechaFin"=>$fechaHasta,"estado"=>"activado","idCliente"=>$_SESSION['id'],"idUsuario"=>"3","idVehiculo"=>$idVehiculo,
          "precioTotal"=>$precioPorDia];

          $objAlquiler->constructor($datos);

          $objAlquiler->crearAlquiler();

    }

//---------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------CAMBIO DE INFORMACION PERSONAL--------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

//Me traigo los datos actuales del encargado logueado
function traerDatosDeCliente(){
  include("../configuracion/configuracion.php");

    $idDelUsuario = $_SESSION['id'];

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM clientes WHERE idCliente = '$idDelUsuario';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $lista = $mysqlPDO->fetchAll();

    $arrayCliente = array(); 
    foreach ($lista as $item) {
      array_push($arrayCliente,$item['nombre'],$item['apellido'],$item['direccion'],$item['telefono'],$item['mail'],$item['usuario'],
      $item['contrasenia'],$item['tipoDocumento'],$item['documento']);
    }
    return $arrayCliente;
}

$clienteLogueado = traerDatosDeCliente(); // pongo los datos en un array para futuras comparaciones


$cambioNombre = "";
$cambioApellido = "";
$cambioDireccion = "";
$cambioTelefono = "";
$cambioMail = "";
$cambioTipoDocumento = "";
$cambioDocumento = "";
$cambioUsuario = "";
$contraseniaActual = "";
$contraseniaNueva = "";

//capturo campos

if(isset($_POST['cambioNombreUsuario'])){

  $cambioNombre = $_POST['cambioNombreUsuario'];
  $cambioNombre= filter_var($cambioNombre, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['cambioApellidoUsuario'])){

  $cambioApellido = $_POST['cambioApellidoUsuario'];
  $cambioApellido= filter_var($cambioApellido, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['cambioDireccion'])){

  $cambioDireccion = $_POST['cambioDireccion'];
  $cambioDireccion= filter_var($cambioDireccion, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['cambioTelefono'])){

  $cambioTelefono = $_POST['cambioTelefono'];
  $cambioTelefono= filter_var($cambioTelefono, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['cambioTipoDocumento'])){

  $cambioTipoDocumento  = $_POST['cambioTipoDocumento'];
  
  
}

if(isset($_POST['cambioDocumento'])){

  $cambioDocumento = $_POST['cambioDocumento'];
  $cambioDocumento= filter_var($cambioDocumento, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['usuarioCambio'])){

  $cambioUsuario = $_POST['usuarioCambio'];
  $cambioUsuario= filter_var($cambioUsuario, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}






if(isset($_POST['cambioMail'])){

  $cambioMail = $_POST['cambioMail'];
  $cambioMail= filter_var($cambioMail, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['contraseniaActualUsuario'])){

  $contraseniaActual = $_POST['contraseniaActualUsuario'];
  $contraseniaActual= filter_var($contraseniaActual, FILTER_SANITIZE_STRING);
  

}

if(isset($_POST['contraseniaNuevaUsuario'])){

  $contraseniaNueva = $_POST['contraseniaNuevaUsuario'];
  $contraseniaNueva= filter_var($contraseniaNueva, FILTER_SANITIZE_STRING);
  

}



//si la contraseña actual es correcta permite realizar modificaciones
if ( $clienteLogueado[6] === $contraseniaActual ) {

  $idDelUsuario = $_SESSION['id'];

  //en caso que los campos sean llenados procede a modificar información, si está vacío simplemente no entra al if
  if(!empty( $cambioNombre )){
    $realizarCambioNombre = "UPDATE clientes
                              SET nombre = '$cambioNombre'
                              WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($realizarCambioNombre);
    $respuesta = $mysqlPDO->execute();
  }

  if(!empty( $cambioApellido )){
    $realizarCambioApellido = "UPDATE clientes
                              SET apellido = '$cambioApellido'
                              WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($realizarCambioApellido);
    $respuesta = $mysqlPDO->execute();
  }

  if(!empty( $cambioDireccion )){
    $realizarCambioDireccion = "UPDATE clientes
                              SET direccion = '$cambioDireccion'
                              WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($realizarCambioDireccion);
    $respuesta = $mysqlPDO->execute();
  }

  if(!empty( $cambioTelefono )){
    $realizarCambioTelefono = "UPDATE clientes
                              SET telefono = '$cambioTelefono'
                              WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($realizarCambioTelefono);
    $respuesta = $mysqlPDO->execute();
  }





  //------------------------MAIL----------------------
  //verifico si el mail existe o no pretende cambiarlo
  $consultaMail = "SELECT mail AS mail
  FROM clientes
  WHERE mail = '$cambioMail'
  UNION
  SELECT mail AS mail
  FROM usuarios
  WHERE mail = '$cambioMail';";

  $mysqlPDO = $conexion->prepare($consultaMail);
  $respuesta = $mysqlPDO->execute();

  $resultado = $mysqlPDO->fetchAll();

  
  if(!empty($resultado)){
    $cambioMail = "";
  }

  if($cambioMail === ""){ //si no cambia el mail, éste sigue siendo el mismo
    $cambioMail = "SELECT mail FROM clientes WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($cambioMail);
    $respuesta = $mysqlPDO->execute();
    $cambioMail = $mysqlPDO->fetchAll();
    $cambioMail = $cambioMail[0]['mail'];
  }











  //----------------------CONTRASEÑA NUEVA----------------------

  if($contraseniaNueva === ""){ //si no cambia la contraseña, esta sigue siendo la misma
    $contraseniaNueva = "SELECT contrasenia FROM clientes WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($contraseniaNueva);
    $respuesta = $mysqlPDO->execute();
    $contraseniaNueva = $mysqlPDO->fetchAll();
    $contraseniaNueva = $contraseniaNueva[0]['contrasenia'];
  }











  //----------------------TIPO Y DOCUMENTO----------------------
  if(!empty($cambioDocumento)){
    
    //compruebo si existe documento
    $tipoDeDocumentoYdocumento = "SELECT * FROM clientes WHERE tipoDocumento = '$cambioTipoDocumento' AND documento = '$cambioDocumento';";
    $mysqlPDO = $conexion->prepare($tipoDeDocumentoYdocumento);
    $respuestaDoc = $mysqlPDO->execute();
    $respuestaDoc  = $mysqlPDO->fetchAll();
    
    if(empty($respuestaDoc)){
      //procedo a realizar los cambios
      $realizarCambiosDocumento = "UPDATE clientes
                                  SET tipoDocumento = '$cambioTipoDocumento', documento = '$cambioDocumento'
                                  WHERE idCliente = '$idDelUsuario';";
      $mysqlPDO = $conexion->prepare($realizarCambiosDocumento);
      $respuesta = $mysqlPDO->execute();
      
    }

    
  }




  //----------------------CAMBIO DE NOMBRE DE USUARIO----------------------
  if(!empty($cambioUsuario)){
    
    //compruebo si existe usuario
    $consultaUsuario = "SELECT usuario AS usuario
                      FROM clientes
                      WHERE usuario = '$cambioUsuario'
                      UNION
                      SELECT usuario AS usuario
                      FROM usuarios
                      WHERE usuario = '$cambioUsuario';";

  $mysqlPDO = $conexion->prepare($consultaUsuario);
  $respuestaUsuario = $mysqlPDO->execute();

  $resultadoUsuario = $mysqlPDO->fetchAll();

  
  //si no lo encuentra permite el ingreso
  if(empty($resultadoUsuario)){
    $realizarCambiosUsuario = "UPDATE clientes
                                  SET usuario = '$cambioUsuario'
                                  WHERE idCliente = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($realizarCambiosUsuario);
    $respuesta = $mysqlPDO->execute();
  }

    
  }






  
  //procedo a realizar los cambios
  $realizarCambios = "UPDATE clientes
                      SET mail = '$cambioMail', contrasenia= '$contraseniaNueva'
                      WHERE idCliente = '$idDelUsuario';";
  $mysqlPDO = $conexion->prepare($realizarCambios);
  $respuesta = $mysqlPDO->execute();
    
  
}





//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------MENSAJE DE CONTACTO-------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

$contactoUsuario = "";
$contactoAsunto = "";
$contactoMensaje = "";

// capturo campos para enviar mensaje de contacto
if(isset($_POST['inputAsunto'])){

  $contactoAsunto = $_POST['inputAsunto'];
  $contactoAsunto= filter_var($contactoAsunto, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if(isset($_POST['inputTexto'])){

  $contactoMensaje = $_POST['inputTexto'];
  $contactoMensaje= filter_var($contactoMensaje, FILTER_SANITIZE_STRING); //evito inyecciones sql
  
  
}

if( !empty($contactoAsunto) &&  !empty($contactoMensaje) ){

  $contactoUsuario = $_SESSION['usuario'];

  $enviarMensaje = "INSERT INTO correo (usuario, asunto, mensaje )
  VALUES ('$contactoUsuario', '$contactoAsunto', '$contactoMensaje');";
  $mysqlPDO = $conexion->prepare($enviarMensaje);
  $respuesta = $mysqlPDO->execute();  
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

  <!-- COMIENZA EL NAV -->

  <ul id="dropdown1" class="dropdown-content">
    <li><a class="modal-trigger" href="#modalCambioDeInformacionUsuario">Cambio de información personal</a></li>
    
    
    
  </ul>
  <ul id="dropdown2" class="dropdown-content">
    <li><a class="modal-trigger" href="#modalCambioDeInformacionUsuario">Cambio de información personal</a></li>
    
    
    
  </ul>

  <nav class="navbar-fixed transparent" role="navigation">
    <div class="nav-wrapper">
      
      <ul class="right hide-on-med-and-down">
        
        
        <li style="padding-right: 2em;"><a class="dropdown-trigger" href="#!" data-target="dropdown1">Opciones<i class="material-icons right">arrow_drop_down</i></a></li>
        <li>
          <form action="interfaz_cliente.php" method="post">
            <input type="hidden" name="txtCerrarSesion1" value="cierroSesion">
            <button type="submit" class="waves-effect waves-teal btn-flat white-text" href="#" name="btnCerrarSesion1">Cerrar sesión</button>
          </form>
        </li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li style="padding-bottom: 3em;">
        <form action="interfaz_cliente.php" method="post">
          <input type="hidden" name="txtCerrarSesion2" value="cierroSesion">
          <button type="submit" class="waves-effect waves-teal btn-flat black-text" href="#" name="btnCerrarSesion2" style="width:100%">Cerrar sesión</button>
        </form>
        </li>
        
        <li><a class="dropdown-trigger" href="#!" data-target="dropdown2">Gestión de usuarios<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <!-- FIN DEL NAV -->




<!-- Modal de reserva -->
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



<!-- PORTADA PRINCIPAL -->
<div id="divPortada" class="row" style="padding: 5rem;">

  <div class="col s12">



    <div class="col s12 m6">

    <div class="card hoverable">
          <div class="card-image waves-effect waves-block waves-light">
          <a href="#divAutomoviles"><img class="responsive-img" src="../web/img/automoviles/portada1.png"> </a>
           
          </div>
          <div class="card-content center">
            <strong class="black-text text-lighten-3">Automóviles</strong>
            <a href="#divAutomoviles" class="btn-floating btn-large pulse grey right"><i class="material-icons">check_circle</i></a>
          </div>
        </div>

    </div>


    <div class="col s12 m6">

    <div class="card hoverable">
          <div class="card-image waves-effect waves-block waves-light">
          <a href="#divVehiculosUtilitarios"><img class="responsive-img" src="../web/img/automoviles/portada2.jpg"></a>
          </div>
          <div class="card-content center">
            <strong class="black-text text-lighten-3">Vehículos utilitarios</strong>
            <a href="#divVehiculosUtilitarios" class="btn-floating btn-large pulse grey right"><i class="material-icons">check_circle</i></a>
          </div>
        </div>

    </div>



    

  </div>

</div>



</div>

<!-- ---------------------------------------------------------------------------------- -->

<div id="divAutomoviles" class="row" style="padding: 0rem 5rem;">

  <!-- carrusel con las distintas marcas para seleccionar -->
  <div id="divCarruselAutos" class="col s12">

      <div class="col s12 center-align">
        <h1>Seleccione una marca por favor</h1>
      </div>

      

      <div class="carousel col s12">
        <a class="carousel-item" href="#one!" onclick="mostrarDivBmw()"><img src="../web/img/bmw-flat-logo.png"></a>
        <a class="carousel-item" href="#two!" onclick="mostrarDivFord()"><img src="../web/img/ford-logo-vector-01.png"></a>
        <a class="carousel-item" href="#three!" onclick="mostrarDivToyota()"><img src="../web/img/toyota-logo-vector.png"></a>
        <a class="carousel-item" href="#four!" onclick="mostrarDivVolkswagen()"><img src="../web/img/volkswagen-auto-vector-logo.png"></a>
      </div>
      


  </div>


  
  <div class="col s12" id="divListaBmw" >

    <div class="row">

      <div class="col s12">

      <?php  foreach ($bmw as $item) {   
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


  <div id="divListaFord" style="display: none;">

  <div class="row">

      <div class="col s12">

      <?php  foreach ($ford as $item) {   
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


  <div id="divListaToyota" style="display: none;">

  <div class="row">

      <div class="col s12">

      <?php  foreach ($toyota as $item) {   
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


  <div id="divListaVolkswagen" style="display: none;">

<div class="row">

      <div class="col s12">

      <?php  foreach ($volkswagen as $item) {   
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

  
 



</div> <!-- fin divAutomoviles -->

<!-- -------------------------------------------------------------------------------------- -->

<div class="divider"><hr></div>
<div class="divider"><hr></div>
  

<div id="divVehiculosUtilitarios" class="row" style="padding: 0rem 5rem;">

  <div id="divCarruselUtilitarios" class="col s12">

      <div class="col s12 center-align">
        <h1>Seleccione una marca por favor</h1>
      </div>

      

      <div class="carousel col s12">
        <a class="carousel-item" href="#three" onclick="mostrardivUtilitariosMitsubishi()"><img src="../web/img/mitsubishi-forklift-trucks-vector-logo.png"></a>
        <a class="carousel-item" href="#four" onclick="mostrardivUtilitariosNewHolland()"><img src="../web/img/new-holland-vector-logo.png"></a>
        
      </div>
      


  </div> <!--fin carrusel -->

  <div id="divUtilitariosMitsubishi">

        <div class="row">

      <div class="col s12">

      <?php  foreach ($mitsubishi as $item) {   
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



        <div id="divUtilitariosNewHolland" style="display: none;">

          <div class="row">

          <div class="col s12">

          <?php  foreach ($newHolland as $item) {   
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




   <!-- Modal cambio de informacion personal -->
<div id="modalCambioDeInformacionUsuario" class="modal">
  <div class="modal-content">
    <div class="container">
      <div class="row">

        <form class="col s12" action="interfaz_cliente.php" method="post">
          <div class="row">

            <div class="col s12 center"><p>Modificar información personal</p></div>

            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="txtRegContrasenia" type="password" class="validate" name="contraseniaActualUsuario" required>
              <label for="txtRegContrasenia">Contraseña actual</label>
              <i onclick="ocultarContraseniaRegistro()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="txtCambioNombreUsuario" type="text" class="validate" name="cambioNombreUsuario" >
              <label for="txtCambioNombreUsuario">Nombre</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="txtCambioApellidoUsuario" type="text" class="validate" name="cambioApellidoUsuario" >
              <label for="txtCambioApellidoUsuario">Apellido</label>
            </div> 

            <div class="input-field col m6">
              <i class="material-icons prefix">home</i>
              <input id="txtDireccion" type="text" class="validate" name="cambioDireccion" >
              <label for="txtDireccion">Dirección</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">call</i>
              <input id="txtTelefono" type="text" class="validate" onkeypress='validate(event)' name="cambioTelefono" >
              <label for="txtTelefono">Telefono</label>
            </div>

            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="txtEmail" type="email" class="validate" name="cambioMail">
              <label for="txtEmail">Email</label>
            </div>

            <div class="input-field col m6">
              <select id="txtTipoDeDocumento" name="cambioTipoDocumento" >
                <option value="cedula">CI</option>
                <option value="credencial">Credencial</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="otro">Otro</option>
              </select>
              <label for="txtTipoDeDocumento">Tipo de documento</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">public</i>
              <input id="txtDocumento" type="text" class="validate" name="cambioDocumento" >
              <label for="txtDocumento">Documento</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="usuarioCambio" type="text" class="validate" name="usuarioCambio" >
              <label for="usuarioCambio">Usuario</label>
            </div>

            <div class="input-field col s6">
              <i class="material-icons prefix">lock</i>
              <input id="txtCambioContrasenia" type="password" class="validate" name="contraseniaNuevaUsuario">
              <label for="txtCambioContrasenia">Nueva contraseña</label>
              <i onclick="ocultarContraseniaCambio()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
            </div>

            <div class="col s12">
              <button class="btn waves-effect waves-light grey darken-1" type="submit" name="btnCambioCliente">Ingresar
                <i class="material-icons right">send</i>
              </button>
            </div>
          </div> 
        </form>

      </div>
    </div>
  </div>
  <div class="modal-footer blue-grey lighten-4">
    <a href="#!" class="modal-close waves-effect waves-black btn-flat">Cerrar</a>
  </div>
</div>
 <!-- fin cambio de informacion personal -->




  <!-- //// botón de enlace para enviar mensaje de contacto \\\\ -->
  <div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light black modal-trigger"  href="#modalContacto"><i class="material-icons">mode_edit</i></a>
  </div>


 
   <div id="modalContacto" class="modal">
    <div class="modal-content row">
      <form action="interfaz_cliente.php" method="post">
      <div class="input-field col s12">
        <input id="input_text" name="inputAsunto" type="text" data-length="20" required>
        <label for="input_text">Asunto</label>
      </div>
      <div class="input-field col s12">
        <textarea id="textarea2" class="materialize-textarea" data-length="250" name="inputTexto" required></textarea>
        <label for="textarea2">Texto</label>
      </div>
      <div class="col s12">
        <button class="btn waves-effect waves-light grey darken-1" type="submit" name="btnContacto">Ingresar
          <i class="material-icons right">send</i>
        </button>
      </div>
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
                <p> © 2022 Copyright Automotora Gambetta</p>
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
