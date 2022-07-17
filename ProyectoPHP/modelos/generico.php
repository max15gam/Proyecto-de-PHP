<?php 


class Usuario{
 
  protected $nombre;
  protected $apellido; 
  protected $mail;
  protected $usuario; 
  protected $contrasenia; 
  protected $estado;

  public function constructor($arrayDatos = array()){
    
    $this->nombre = $arrayDatos['nombre'];
    $this->apellido = $arrayDatos['apellido'];
    $this->mail = $arrayDatos['mail'];
    $this->usuario = $arrayDatos['usuario'];
    $this->contrasenia = $arrayDatos['contrasenia'];
    $this->estado = $arrayDatos['estado'];

  }

  public function ejecutarSentencia($sqlSentencia,$arrayEjecutar = array()){

    include("configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $mysqlPDO = $conexion->prepare($sqlSentencia);
    $respuesta = $mysqlPDO->execute($arrayEjecutar);

    return $respuesta;
  }


  //--------------------------------------------\\
  //-------Listados por tipo de consulta---------\\
  //----------------------------------------------\\


  //listado de clientes
  public function listaClientes($listado = array()){

    include("configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlClientes = "SELECT * FROM clientes;";

    $mysqlPDO = $conexion->prepare($sqlClientes);
    $respuesta = $mysqlPDO->execute();

    $listaClientes = $mysqlPDO->fetchAll();

    return $listaClientes;

  }

  //listado de tanto de usuarios empleados como de clientes para verificar en el registro de un nuevo ingreso
  public function listaPorUsuarioMail($listado = array()){
    include("configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlUsuarioMail = "SELECT usuario, mail FROM clientes
                       UNION 
                       SELECT usuario, mail FROM usuarios;";

    $mysqlPDO = $conexion->prepare($sqlUsuarioMail);
    $respuesta = $mysqlPDO->execute();

    $listaUsuarioMail = $mysqlPDO->fetchAll();

    return $listaUsuarioMail;
  }

  

}

//---------------------------------------------------------------------------------------------

class Alquiler{

  private $idAlquiler;
  private $fechaInicio; 
  private $fechaFin;
  private $estado; 
  private $idCliente; 
  private $idUsuario;
  private $idVehiculo;
  private $precioTotal;

  public function constructor($arrayDatos = array()){
    
    
    $this->fechaInicio = $arrayDatos['fechaInicio'];
    $this->fechaFin = $arrayDatos['fechaFin'];
    $this->estado = $arrayDatos['estado'];
    $this->idCliente = $arrayDatos['idCliente'];
    $this->idUsuario = $arrayDatos['idUsuario'];
    $this->idVehiculo = $arrayDatos['idVehiculo'];
    $this->precioTotal = $arrayDatos['precioTotal'];
  }

  


public function ejecutarSentencia($sqlSentencia,$arrayEjecutar = array()){

  include("../configuracion/configuracion.php");

  $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

  $mysqlPDO = $conexion->prepare($sqlSentencia);
  $respuesta = $mysqlPDO->execute($arrayEjecutar);

  return $respuesta;
}

public function consultarDisponibilidad($fechaDeInicio,$fechaFinal,$idDelVehiculo){
  $consulta =  "SELECT * FROM alquileres WHERE idVehiculo = '$idDelVehiculo' AND (('$fechaDeInicio' BETWEEN fechaInicio AND fechaFin) 
    OR ('$fechaFinal' BETWEEN fechaInicio AND fechaFin)) AND estado = 'activado';";

  include("../configuracion/configuracion.php");

  $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $mysqlPDO = $conexion->prepare($consulta);
  $respuesta = $mysqlPDO->execute();

  $lista = $mysqlPDO->fetchAll();

  $arrayCoincidencias = array();
  
  foreach ($lista as $item) {
    array_push($arrayCoincidencias,$item['idAlquiler']);
  }


  return $arrayCoincidencias;
}

public function crearAlquiler(){


  include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO alquileres (fechaInicio,fechaFin,estado,idCliente,idUSuario,idVehiculo,precioTotal) 
    VALUES (:fechaInicio,:fechaFin,:estado,:idCliente,:idUsuario,:idVehiculo,:precioTotal);";

  $arrayAlquiler = [
 
  "fechaInicio"=>$this->fechaInicio,
  "fechaFin"=>$this->fechaFin,
  "estado"=>$this->estado,
  "idCliente"=>$this->idCliente,
  "idUsuario"=>$this->idUsuario,
  "idVehiculo"=>$this->idVehiculo,
  "precioTotal"=>$this->precioTotal
  ];

  //-----------------------------------------------------\\
  //--------------------CONTROLES------------------------\\
  //-----------------------------------------------------\\
  
  //compruebo si las fechas ingresadas son válidas
  $fechaActual = date("Y-m-d");
  
  /*evalúo que la fecha de alquiler sea igual o mayor a la fecha actual, lo mismo para la fecha de finalización.
  También evalúo que la fecha de finalización sea mayor a la del alquiler*/

  if ($arrayAlquiler['fechaInicio'] >= $fechaActual && 
  $arrayAlquiler['fechaFin'] >= $fechaActual && $arrayAlquiler['fechaFin'] > $arrayAlquiler['fechaInicio'] ){
    
    //calculo la cantidad de días de alquiler y multiplico por el monto para obtener el total
    $cantidadDeDias =  strtotime($arrayAlquiler['fechaFin']) - strtotime($arrayAlquiler['fechaInicio']);

    $cantidadDeDias = round($cantidadDeDias / (60 * 60 * 24));

    $arrayAlquiler['precioTotal'] = $arrayAlquiler['precioTotal'] * $cantidadDeDias;

    //consulto si el vehículo está disponible entre esas fechas
    $disponibilidad = $this->consultarDisponibilidad($arrayAlquiler['fechaInicio'],$arrayAlquiler['fechaFin'],$arrayAlquiler['idVehiculo']);

    /*si hay registros dentro del rango de fecha o sea si está alquilado para esas fechas rechaza el ingreso. De
    lo contrario ingresa el aquiler */
    if (empty($disponibilidad)) {
      
      $retorno = $this->ejecutarSentencia($sql,$arrayAlquiler);
      return $retorno;

      
    }else{
      
      // session_start();
      $_SESSION['idVehiculo'] = $arrayAlquiler['idVehiculo'];
      if($_SESSION['documento_o_tipoUsuario'] != "administrador" && $_SESSION['documento_o_tipoUsuario'] != "encargado"
      && $_SESSION['documento_o_tipoUsuario'] != "vendedor"){
        header('Location: ../backend/sugerencias.php');
        exit();
      }
      
      
    }
   
    

  }else{
    
    
  }
  

  
 
}


}


//----------------------------------------------------------------------------------------------------

class Vehiculo{

  private $tipoVehiculo;
  private $cantidadPasajeros; 
  private $marca;
  private $modelo; 
  private $color; 
  private $matricula;
  private $precio;
  private $estado;
  private $imagen;


  public function constructor($arrayDatos = array()){
    
    
    $this->tipoVehiculo = $arrayDatos['tipoVehiculo'];
    $this->cantidadPasajeros = $arrayDatos['cantidadPasajeros'];
    $this->marca = $arrayDatos['marca'];
    $this->modelo = $arrayDatos['modelo'];
    $this->color = $arrayDatos['color'];
    $this->matricula = $arrayDatos['matricula'];
    $this->precio = $arrayDatos['precio'];
    $this->estado = $arrayDatos['estado'];
    $this->imagen = $arrayDatos['imagen'];

    
  }



public function nuevoVehiculo(){


  $arrayVehiculo = [
 
  "tipoVehiculo"=>$this->tipoVehiculo,
  "cantidadPasajeros"=>$this->cantidadPasajeros,
  "marca"=>$this->marca,
  "modelo"=>$this->modelo,
  "color"=>$this->color,
  "matricula"=>$this->matricula,
  "precio"=>$this->precio,
  "estado"=>$this->estado,
  "imagen"=>$this->imagen
  ];

  

  include("../configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO vehiculos (tipoVehiculo,cantidadPasajeros,marca,modelo,color,matricula,precio,estado,imagen) 
    VALUES (:tipoVehiculo,:cantidadPasajeros,:marca,:modelo,:color,:matricula,:precio,:estado,:imagen);";
  
  $mysqlPDO = $conexion->prepare($sql);
  $respuesta = $mysqlPDO->execute($arrayVehiculo);
  

}

}



?>