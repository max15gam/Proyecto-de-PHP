<?php 

session_start();

//contengo el error si se intenta recargar la página o al recargar la página principal, ya que la sesión expira
if(!isset($_SESSION['usuario']) && empty($_SESSION['usuario']) || $_SESSION['documento_o_tipoUsuario'] != "encargado" ) {
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




require_once("../modelos/generico.php");
require_once("../modelos/registroClientes.php");
include("../configuracion/configuracion.php");


    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();
  
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------GENERAR UN NUEVO ALQUILER----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

    $usuario = "";
    $vehiculo = "";
    $fechaDesde = "";
    $FechaHasta = "";

    //capturo campos
    if(isset($_POST['registroUsuarioAlquiler'])){

      $usuario = $_POST['registroUsuarioAlquiler'];
      $usuario =str_replace(' ', '', $usuario); //elimino espacios en blanco dentro de la cadena de texto
      
    }

    if(isset($_POST['registroVehiculoAlquiler'])){

      $vehiculo = $_POST['registroVehiculoAlquiler'];
      if (($pos = strpos($vehiculo, "$")) !== FALSE) { 
        $precio = substr($vehiculo, $pos+1); 
      }
      // $precio = substr($vehiculo, strpos($vehiculo, "@") + 1);
      $idVehiculo = strtok($vehiculo, '$');
     
    }

    if(isset($_POST['registroFechaDesdeAlquiler'])){

      $fechaDesde = $_POST['registroFechaDesdeAlquiler'];
      
    }

    if(isset($_POST['registroFechaHastaAlquiler'])){

      $fechaHasta = $_POST['registroFechaHastaAlquiler'];
      
    }

    
    if( !empty($fechaDesde) || !empty($fechaHasta) || !empty($usuario) || !empty($idVehiculo) || !empty($precio) ){

          $objAlquiler = new Alquiler();

          $datos = ["fechaInicio"=>$fechaDesde,"fechaFin"=>$fechaHasta,"estado"=>"activado","idCliente"=>$usuario,"idUsuario"=>$_SESSION['id'],"idVehiculo"=>$idVehiculo,
          "precioTotal"=>$precio];

          $objAlquiler->constructor($datos);

          $objAlquiler->crearAlquiler();

    }
    

    
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------INGRESAR UN NUEVO VEHICULO----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

$ingresoVehiculoTipo = "";
$ingresoVehiculoCantidadPasajeros = "";
$ingresoVehiculoMarca = "";
$ingresoVehiculoModelo = "";
$ingresoVehiculoColor = "";
$ingresoVehiculoMatricula = "";
$ingresoVehiculoPrecio = "";
$ingresoVehiculoImagen = "";

if(isset($_POST['ingresoVehiculoTipo'])){
  $ingresoVehiculoTipo = $_POST['ingresoVehiculoTipo'];
  
}

if(isset($_POST['txtVehiculoPasajeros'])){
  $ingresoVehiculoCantidadPasajeros = $_POST['txtVehiculoPasajeros'];
  
}

if(isset($_POST['txtVehiculoMarca'])){

  $ingresoVehiculoMarca = $_POST['txtVehiculoMarca'];
  $ingresoVehiculoMarca =str_replace(' ', '', $ingresoVehiculoMarca); //elimino espacios en blanco dentro de la cadena de texto
  
}

if(isset($_POST['txtVehiculoModelo'])){

  $ingresoVehiculoModelo = $_POST['txtVehiculoModelo'];
  $ingresoVehiculoModelo =str_replace(' ', '', $ingresoVehiculoModelo); //elimino espacios en blanco dentro de la cadena de texto

}

if(isset($_POST['txtVehiculoColor'])){
  $ingresoVehiculoColor = $_POST['txtVehiculoColor'];
  $ingresoVehiculoColor =str_replace(' ', '', $ingresoVehiculoColor); //elimino espacios en blanco dentro de la cadena de texto
  
}

if(isset($_POST['txtVehiculoMatricula'])){

  $ingresoVehiculoMatricula = $_POST['txtVehiculoMatricula'];
  $ingresoVehiculoMatricula =str_replace(' ', '', $ingresoVehiculoMatricula); //elimino espacios en blanco dentro de la cadena de texto
}

if(isset($_POST['txtVehiculoPrecio'])){
  $ingresoVehiculoPrecio = $_POST['txtVehiculoPrecio'];
 
  
}


if(isset($_FILES['txtImagen']['name'])){

  
    
  $ingresoVehiculoImagen = $_FILES['txtImagen']['name'];
 
}



if( !empty($ingresoVehiculoCantidadPasajeros) && !empty($ingresoVehiculoMarca) && !empty($ingresoVehiculoModelo) && 
!empty($ingresoVehiculoColor) && !empty($ingresoVehiculoMatricula) && !empty($ingresoVehiculoPrecio) && 
!empty($ingresoVehiculoImagen)  ){

  $objVehiculo = new Vehiculo();

  $datosVehiculo = ["tipoVehiculo"=>$ingresoVehiculoTipo,"cantidadPasajeros"=>$ingresoVehiculoCantidadPasajeros,
  "marca"=>$ingresoVehiculoMarca,"modelo"=>$ingresoVehiculoModelo,"color"=>$ingresoVehiculoColor,
  "matricula"=>$ingresoVehiculoMatricula,"precio"=>$ingresoVehiculoPrecio ,"estado"=>"activado", "imagen"=>$ingresoVehiculoImagen];
  
  $objVehiculo->constructor($datosVehiculo);

  $objVehiculo->nuevoVehiculo();

  $ruta = "../web/img/automoviles/" . $_FILES['txtImagen']['name'];
    
  copy( $_FILES['txtImagen']['tmp_name'] , $ruta );


}



//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------GESTIÓN CLIENTES----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

$sqlClientes = "SELECT * FROM clientes;";

    $mysqlPDO = $conexion->prepare($sqlClientes);
    $respuesta = $mysqlPDO->execute();

    $listaClientes = $mysqlPDO->fetchAll();

//activo cliente al presionar para activarlo
if(isset($_POST['accion']) && $_POST['accion'] == "activado" ){

  if(  isset($_POST['idCliente'])  && $_POST['idCliente'] != ""){
    
    $idDelCliente = $_POST['idCliente'];
    $estadoDelCliente = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE clientes
    SET estado = '$estadoDelCliente'
    WHERE idCliente= '$idDelCliente';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    //vuelvo a hacer la query para que me imprima en tiempo real los datos modificados
    $sqlClientes = "SELECT * FROM clientes;";

    $mysqlPDO = $conexion->prepare($sqlClientes);
    $respuesta = $mysqlPDO->execute();

    $listaClientes = $mysqlPDO->fetchAll();
    
  } 
    
}

//activo cliente al presionar para desactivarlo
if(isset($_POST['accion']) && $_POST['accion'] == "desactivado" ){

  if(  isset($_POST['idCliente'])  && $_POST['idCliente'] != ""){
    
    $idDelCliente = $_POST['idCliente'];
    $estadoDelCliente = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE clientes
    SET estado = '$estadoDelCliente'
    WHERE idCliente= '$idDelCliente';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlClientes = "SELECT * FROM clientes;";

    $mysqlPDO = $conexion->prepare($sqlClientes);
    $respuesta = $mysqlPDO->execute();

    $listaClientes = $mysqlPDO->fetchAll();
    
  } 
    
}


//activo cliente al presionar para eliminarlo
if(isset($_POST['accion']) && $_POST['accion'] == "borrado" ){

  if(  isset($_POST['idCliente'])  && $_POST['idCliente'] != ""){
    
    $idDelCliente = $_POST['idCliente'];
    $estadoDelCliente = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE clientes
    SET estado = '$estadoDelCliente'
    WHERE idCliente= '$idDelCliente';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlClientes = "SELECT * FROM clientes;";

    $mysqlPDO = $conexion->prepare($sqlClientes);
    $respuesta = $mysqlPDO->execute();

    $listaClientes = $mysqlPDO->fetchAll();
    
  } 
    
}

//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------GESTIÓN VEHÍCULOS----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

$sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();

//activo vehiculo al presionar para activarlo
if(isset($_POST['accion']) && $_POST['accion'] == "activado" ){

  if(  isset($_POST['idVehiculo'])  && $_POST['idVehiculo'] != ""){
    
    $idDelVehiculo = $_POST['idVehiculo'];
    $estadoDelVehiculo = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE vehiculos
    SET estado = '$estadoDelVehiculo'
    WHERE idVehiculo= '$idDelVehiculo';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();
    
  } 
    
}

//activo cliente al presionar para desactivarlo
if(isset($_POST['accion']) && $_POST['accion'] == "desactivado" ){

  if(  isset($_POST['idVehiculo'])  && $_POST['idVehiculo'] != ""){
    
    $idDelVehiculo = $_POST['idVehiculo'];
    $estadoDelVehiculo = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE vehiculos
    SET estado = '$estadoDelVehiculo'
    WHERE idVehiculo= '$idDelVehiculo';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();
    
  } 
    
}


//activo cliente al presionar para eliminarlo
if(isset($_POST['accion']) && $_POST['accion'] == "borrado" ){

  if(  isset($_POST['idVehiculo'])  && $_POST['idVehiculo'] != ""){
    
    $idDelVehiculo = $_POST['idVehiculo'];
    $estadoDelVehiculo = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE vehiculos
    SET estado = '$estadoDelVehiculo'
    WHERE idVehiculo= '$idDelVehiculo';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlVehiculos = "SELECT * FROM vehiculos;";

    $mysqlPDO = $conexion->prepare($sqlVehiculos);
    $respuesta = $mysqlPDO->execute();

    $listaVehiculos = $mysqlPDO->fetchAll();
    
  } 
    
}



//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------GESTIÓN ALQUILERES----------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

$sqlAlquileres = "SELECT * FROM alquileres;";

    $mysqlPDO = $conexion->prepare($sqlAlquileres);
    $respuesta = $mysqlPDO->execute();

    $listaAlquileres = $mysqlPDO->fetchAll();

//activo alquiler al presionar para activarlo
if(isset($_POST['accion']) && $_POST['accion'] == "activado" ){

  if(  isset($_POST['idAlquiler'])  && $_POST['idAlquiler'] != ""){
    
    $idDelAlquiler = $_POST['idAlquiler'];
    $estadoDelAlquiler = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE alquileres
    SET estado = '$estadoDelAlquiler'
    WHERE idAlquiler= '$idDelAlquiler';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlAlquileres = "SELECT * FROM alquileres;";

    $mysqlPDO = $conexion->prepare($sqlAlquileres);
    $respuesta = $mysqlPDO->execute();

    $listaAlquileres = $mysqlPDO->fetchAll();
    
  } 
    
}

//activo alquiler al presionar para desactivarlo
if(isset($_POST['accion']) && $_POST['accion'] == "desactivado" ){

  if(  isset($_POST['idAlquiler'])  && $_POST['idAlquiler'] != ""){
    
    $idDelAlquiler = $_POST['idAlquiler'];
    $estadoDelAlquiler = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE alquileres
    SET estado = '$estadoDelAlquiler'
    WHERE idAlquiler= '$idDelAlquiler';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlAlquileres = "SELECT * FROM alquileres;";

    $mysqlPDO = $conexion->prepare($sqlAlquileres);
    $respuesta = $mysqlPDO->execute();

    $listaAlquileres = $mysqlPDO->fetchAll();
    
  } 
    
}


//activo alquiler al presionar para eliminarlo
if(isset($_POST['accion']) && $_POST['accion'] == "borrado" ){

  if(  isset($_POST['idAlquiler'])  && $_POST['idAlquiler'] != ""){
    
    $idDelAlquiler = $_POST['idAlquiler'];
    $estadoDelAlquiler = $_POST['accion'];

    include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE alquileres
    SET estado = '$estadoDelAlquiler'
    WHERE idAlquiler= '$idDelAlquiler';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $sqlAlquileres = "SELECT * FROM alquileres;";

    $mysqlPDO = $conexion->prepare($sqlAlquileres);
    $respuesta = $mysqlPDO->execute();

    $listaAlquileres = $mysqlPDO->fetchAll();
    
  } 
    
}


//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------CAMBIO DE INFORMACION PERSONAL--------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

//Me traigo los datos actuales del encargado logueado
function traerDatosDeEncargado(){
  include("../configuracion/configuracion.php");

    $idDelUsuario = $_SESSION['id'];

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM usuarios WHERE tipoUsuario = 'encargado' AND idUsuario = '$idDelUsuario';";

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute();

    $lista = $mysqlPDO->fetchAll();

    $arrayEncargado = array(); 
    foreach ($lista as $item) {
      array_push($arrayEncargado,$item['mail'],$item['contrasenia']);
    }
    return $arrayEncargado;
}

$encargadoLogueado = traerDatosDeEncargado(); // pongo los datos en un array para futuras comparaciones



$cambioMail = "";
$contraseniaActual = "";
$contraseniaNueva = "";

//capturo campos
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


if ( $encargadoLogueado[1] === $contraseniaActual ) {

  $idDelUsuario = $_SESSION['id'];
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
    $cambioMail = "SELECT mail FROM usuarios WHERE tipoUsuario = 'encargado' AND idUsuario = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($cambioMail);
    $respuesta = $mysqlPDO->execute();
    $cambioMail = $mysqlPDO->fetchAll();
    $cambioMail = $cambioMail[0]['mail'];
  }

  //----------------------CONTRASEÑA NUEVA----------------------

  if($contraseniaNueva === ""){ //si no cambia la contraseña, esta sigue siendo la misma
    $contraseniaNueva = "SELECT contrasenia FROM usuarios WHERE tipoUsuario = 'encargado' AND idUsuario = '$idDelUsuario';";
    $mysqlPDO = $conexion->prepare($contraseniaNueva);
    $respuesta = $mysqlPDO->execute();
    $contraseniaNueva = $mysqlPDO->fetchAll();
    $contraseniaNueva = $contraseniaNueva[0]['contrasenia'];
  }

  //procedo a realizar los cambios
  $realizarCambios = "UPDATE usuarios
                      SET mail = '$cambioMail', contrasenia= '$contraseniaNueva'
                      WHERE idUsuario = '$idDelUsuario';";
  $mysqlPDO = $conexion->prepare($realizarCambios);
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
    }
    table, th, td {
        
        border-style: outset;
      }

    
  </style>
  
</head>
<body>



  <!-- COMIENZA EL NAV -->

  <ul id="dropdown1" class="dropdown-content">
    <li><a href="#!" onclick="mostrarDivListadoAlquileres()">Alquileres</a></li>
    <li class="divider"></li>
    <li><a href="#!" onclick="mostrarDivListadoClientes()">Clientes</a></li>
    <li class="divider"></li>
    <li><a href="#!" onclick="mostrarDivListadoVehiculos()">Vehículos</a></li>
    
    
  </ul>
  <ul id="dropdown2" class="dropdown-content">
    <li><a href="#!" onclick="mostrarDivListadoAlquileres()">Alquileres</a></li>
    <li class="divider"></li>
    <li><a href="#!" onclick="mostrarDivListadoClientes()">Clientes</a></li>
    <li class="divider"></li>
    <li><a href="#!" onclick="mostrarDivListadoVehiculos()">Vehículos</a></li>
    
    
  </ul>

  <nav class="navbar-fixed green" role="navigation">
    <div class="nav-wrapper">
      
      <ul class="right hide-on-med-and-down">
        <li><a  href="#" onclick="mostrarDivIngresoAlquileres()">Ingresar alquiler</a></li>
        <li><a href="#" onclick="mostrarDivIngresoVehiculos()">Ingresar vehiculo</a></li>
        <li style="padding-right: 2em;"><a class="dropdown-trigger" href="#!" data-target="dropdown1">Registros<i class="material-icons right">arrow_drop_down</i></a></li>
        <li>
          <form action="interfaz_encargado.php" method="post">
            <input type="hidden" name="txtCerrarSesion1" value="cierroSesion">
            <button type="submit" class="btn-flat white-text" href="#" name="btnCerrarSesion1">Cerrar sesión</button>
          </form>
        </li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li style="padding-bottom: 3em;">
        <form action="interfaz_encargado.php" method="post">
          <input type="hidden" name="txtCerrarSesion2" value="cierroSesion">
          <button type="submit" class="btn grey darken-4" href="#" name="btnCerrarSesion2" style="width:100%">Cerrar sesión</button>
        </form>
        </li>
        <li><a class="btn grey darken-4" href="#" onclick="mostrarDivIngresoAlquileres()">Ingresar alquiler</a></li>
        <li><a class="btn grey darken-4" href="#" onclick="mostrarDivIngresoVehiculos()">Ingresar vehiculo</a></li>
        <li><a class="dropdown-trigger" href="#!" data-target="dropdown2">Gestión de usuarios<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <!-- FIN DEL NAV -->

  
  <div class="container" style="padding-top: 5em;padding-bottom: 5em;">

      

    <!-- DIV INGRESO DE ALQUILERES -->
    <div id="divIngresoAlquileres">
        <div class="row">
            <div class="col s12">
            <form action="interfaz_encargado.php" method="post" style="padding: 5em;">
              <div class="row">

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="alquilerUsuario" type="text" class="validate" name="registroUsuarioAlquiler" onkeypress='validate(event)' required>
                  <label for="alquilerUsuario">Usuario</label>
                </div>

                <div class="input-field col s6">
                  <select name="registroVehiculoAlquiler">
                  
                    <?php  foreach ($listaVehiculos as $item): ?>

                    
                      <option value="<?php echo $item['idVehiculo'] . "$". $item['precio'] ?>"><?php echo $item['marca'] . "(" . $item['modelo'] . ") - Color: ". $item['color'] ?></option>
                      
                

                    <?php endforeach ?>
                

                  </select>
                  <label>Vehículo</label>
                </div>
                <div class="input-field col s6">
                  <input id="alquilerDesde" type="text" class="datepicker" name="registroFechaDesdeAlquiler" required>
                  <label for="alquilerDesde">Desde</label>
                </div>
                <div class="input-field col s6">
                  <input id="alquilerHasta" type="text" class="datepicker" name="registroFechaHastaAlquiler" required>
                  <label for="alquilerHasta">Hasta</label>
                </div>
                <div class="input-field col s6">
                <button class="btn waves-effect waves-light grey darken-1" type="submit" name="action">Ingresar
                  <i class="material-icons right">send</i>
                </button>
                </div>
              </div>
            </form>
            </div>             
            
            
            
          
        </div>

    </div>

    <!-- DIV INGRESO DE VEHICULOS -->
    <div id="divIngresoVehiculos" style="min-height: 20em; display: none;">
        <div class="row">
          
            <form class="col s12" action="interfaz_encargado.php" method="post" enctype="multipart/form-data" style="padding: 5em;">
              <div class="row">

                <div class="input-field col s6">
                  <select name="ingresoVehiculoTipo">
                      <option value="automovil">Automovil</option>
                      <option value="tractor">Tractor</option>
                      <option value="autoelevador">Autoelevador</option>
                   </select>
                  <label>Tipo de vehículo</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoPasajeros" type="text" class="validate" name="txtVehiculoPasajeros" onkeypress='validate(event)' required>
                  <label for="ingresoVehiculoPasajeros">Cantidad de pasajeros</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoMarca" type="text" class="validate" name="txtVehiculoMarca" required>
                  <label for="ingresoVehiculoMarca">Marca</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoModelo" type="text" class="validate" name="txtVehiculoModelo" required>
                  <label for="ingresoVehiculoModelo">Modelo</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoColor" type="text" class="validate" name="txtVehiculoColor" required>
                  <label for="ingresoVehiculoColor">Color</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoMatricula" type="text" class="validate" name="txtVehiculoMatricula" required>
                  <label for="ingresoVehiculoMatricula">Matricula</label>
                </div>

                <div class="input-field col s6">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="ingresoVehiculoPrecio" type="text" class="validate" name="txtVehiculoPrecio" onkeypress='validate(event)' required>
                  <label for="ingresoVehiculoPrecio">Precio</label>
                </div>

                <div class="file-field input-field col s6">
                  <div class="btn">
                    <span> <i class="material-icons center">camera_alt</i></span>
                    <input type="file" name="txtImagen">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Subir una imagen">
                  </div>
                </div>

                <div class="input-field col s12">
                <button class="btn waves-effect waves-light grey darken-1" type="submit" name="btnNuevoVehiculo">Ingresar
                  <i class="material-icons right">send</i>
                </button>
                
                </div>
              </div>
            </form>
          
        </div>

    </div>



    <!-- DIV LISTADO DE CLIENTES -->
    <div id="divListadoClientes" style="min-height: 20em; display: none;">
    <table class="striped centered responsive-table">
      <thead>
        <tr>
          <th>id</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Mail</th>
          <th>Usuario</th>
          <th>Tipo de documento</th>
          <th>Documento</th>
          <th>Estado</th>
          <th>Activar</th>
          <th>Desactivar</th>
          <th>Eliminar</th>
          
        </tr>
      </thead>
      <tbody>

        <?php     foreach ($listaClientes as $item) {   
        ?>

        <tr>
          <td><?=$item['idCliente'] ?></td>
          <td><?=$item['nombre'] ?></td>
          <td><?=$item['apellido'] ?></td>
          <td><?=$item['direccion'] ?></td>
          <td><?=$item['telefono'] ?></td>
          <td><?=$item['mail'] ?></td>
          <td><?=$item['usuario'] ?></td>
          <td><?=$item['tipoDocumento'] ?></td>
          <td><?=$item['documento'] ?></td>
          <td><?=$item['estado'] ?></td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="activado">
              <input type="hidden" name="idCliente" value="<?=$item['idCliente']?>">
              <input type="hidden" name="formulario" value="divListadoClientes">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">person_add</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="desactivado">
              <input type="hidden" name="idCliente" value="<?=$item['idCliente']?>">
              <input type="hidden" name="formulario" value="divListadoClientes">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">pause_circle_filled</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="borrado">
              <input type="hidden" name="idCliente" value="<?=$item['idCliente']?>">
              <input type="hidden" name="formulario" value="divListadoClientes">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">delete</i>
              </button>
            </form>
          </td>
        </tr>
               
        <?php  }
        ?>       
        
        
      </tbody>
      
    </table>              

    </div>

    <!-- DIV LISTADO DE VEHICULOS -->
    <div id="divListadoVehiculos" style="min-height: 20em; display: none;">
    <table class="striped centered responsive-table">
      <thead>
        <tr>
          <th>id</th>
          <th>Tipo de vehículo</th>
          <th>Cantidad de pasajeros</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Color</th>
          <th>Matricula</th>
          <th>Precio por día</th>
          <th>Estado</th>
          <th>Activar</th>
          <th>Desactivar</th>
          <th>Eliminar</th>
          
        </tr>
      </thead>
      <tbody>

        <?php     foreach ($listaVehiculos as $item) {   
        ?>

        <tr>
          <td><?=$item['idVehiculo'] ?></td>
          <td><?=$item['tipoVehiculo'] ?></td>
          <td><?=$item['cantidadPasajeros'] ?></td>
          <td><?=$item['marca'] ?></td>
          <td><?=$item['modelo'] ?></td>
          <td><?=$item['color'] ?></td>
          <td><?=$item['matricula'] ?></td>
          <td><?=$item['precio'] ?></td>
          <td><?=$item['estado'] ?></td>
          <td>
          <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="activado">
              <input type="hidden" name="idVehiculo" value="<?=$item['idVehiculo']?>">
              <input type="hidden" name="formulario" value="divListadoVehiculos">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">person_add</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="desactivado">
              <input type="hidden" name="idVehiculo" value="<?=$item['idVehiculo']?>">
              <input type="hidden" name="formulario" value="divListadoVehiculos">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">pause_circle_filled</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="borrado">
              <input type="hidden" name="idVehiculo" value="<?=$item['idVehiculo']?>">
              <input type="hidden" name="formulario" value="divListadoVehiculos">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">delete</i>
              </button>
            </form>
          </td>
        </tr>
               
        <?php  }
        ?>       
        
        
      </tbody>
      
    </table>               

    </div>

    

    

    <!-- DIV LISTADO DE ALQUILERES -->
    <div id="divListadoAlquileres" style="min-height: 20em; display: none;">
    <table class="striped centered responsive-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Fecha de alquiler</th>
          <th>Fecha de entrega</th>
          <th>Estado</th>
          <th>Id cliente</th>
          <th>Id empleado</th>
          <th>Id vehículo</th>
          <th>Monto del alquiler</th>
          <th>Activar</th>
          <th>Desactivar</th>
          <th>Eliminar</th>
          
        </tr>
      </thead>
      <tbody>

        <?php     foreach ($listaAlquileres as $item) {   
        ?>

        <tr>
          <td><?=$item['idAlquiler'] ?></td>
          <td><?=$item['fechaInicio'] ?></td>
          <td><?=$item['fechaFin'] ?></td>
          <td><?=$item['estado'] ?></td>
          <td><?=$item['idCliente'] ?></td>
          <td><?=$item['idUsuario'] ?></td>
          <td><?=$item['idVehiculo'] ?></td>
          <td><?=$item['precioTotal'] ?></td>

          <td>
          <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="activado">
              <input type="hidden" name="idAlquiler" value="<?=$item['idAlquiler']?>">
              <input type="hidden" name="formulario" value="divListadoAlquileres">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">person_add</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="desactivado">
              <input type="hidden" name="idAlquiler" value="<?=$item['idAlquiler']?>">
              <input type="hidden" name="formulario" value="divListadoAlquileres">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">pause_circle_filled</i>
              </button>
            </form>
          </td>
          <td>
            <form action="interfaz_encargado.php" method="POST">
              <input type="hidden" name="accion" value="borrado">
              <input type="hidden" name="idAlquiler" value="<?=$item['idAlquiler']?>">
              <input type="hidden" name="formulario" value="divListadoAlquileres">
              <button class="btn waves-effect waves-light" type="submit" name="action">
              <i class="material-icons center">delete</i>
              </button>
            </form>
          </td>
        </tr>
               
        <?php  }
        ?>       
        
        
      </tbody>
      
    </table>  
    </div>

  </div>
    
    <!-- CAMBIO DE INFORMACION PERSONAL -->
  <div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light green modal-trigger" href="#modalCambioDeInformacionUsuario"><i class="material-icons">mode_edit</i></a>
  </div>

  <!-- Modal cambio de informacion personal -->
<div id="modalCambioDeInformacionUsuario" class="modal">
  <div class="modal-content">
    <div class="container">
      <div class="row">

        <form class="col s12" action="interfaz_encargado.php" method="post">
          <div class="row">

            <div class="col s12 center"><p>Modificar información personal</p></div>

            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="txtEmail" type="email" class="validate" name="cambioMail">
              <label for="txtEmail">Email</label>
            </div>

            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="txtRegContrasenia" type="password" class="validate" name="contraseniaActualUsuario" required>
              <label for="txtRegContrasenia">Contraseña actual</label>
              <i onclick="ocultarContraseniaRegistro()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
            </div>

            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="txtCambioContrasenia" type="password" class="validate" name="contraseniaNuevaUsuario">
              <label for="txtCambioContrasenia">Nueva contraseña</label>
              <i onclick="ocultarContraseniaCambio()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
            </div>

            <div class="col s12">
              <button class="btn waves-effect waves-light grey darken-1" type="submit" name="btnRegistrarCliente">Ingresar
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





  <!--  Scripts-->
 
  <script src="../web/js/jquery-2.1.1.js"></script>
  <script src="../web/js/materialize.js"></script>
  <script src="../web/js/init.js"></script>
  <script src="../web/js/scripts_encargado.js"></script>
  <script>
    $(".dropdown-trigger").dropdown();
    <?php
    if( isset($_POST['formulario']) ){
      
        
      echo('document.getElementById("divIngresoAlquileres").style.display = "none";');
      echo('document.getElementById("'.$_POST['formulario'].'").style.display = "block";');
    }
    ?>
  </script>
  



  </body>


  
</html>