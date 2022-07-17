<?php 

require_once("generico.php");

class Login extends Usuario{

  public $usuarioLogueo; 
  public $contraseniaLogueo; 
  

  public function constructor($arrayDatos = array()){
    parent::listaPorUsuarioMail();
    $this->usuarioLogueo = $arrayDatos['usuarioLogueo'];
    $this->contraseniaLogueo = $arrayDatos['contraseniaLogueo'];
    
  }

  public function iniciarSesion(){

    include("configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 
      "SELECT usuario, contrasenia, idCliente AS id, nombre, apellido, mail, documento AS documento_o_tipoUsuario
      FROM clientes
      WHERE usuario = :usuarioLogueo AND (contrasenia = :contraseniaLogueo OR codigo = :contraseniaLogueo) AND estado='activado'
      UNION
      SELECT usuario, contrasenia, idUsuario AS id, nombre, apellido, mail, tipoUsuario AS documento_o_tipoUsuario
      FROM usuarios
      WHERE usuario = :usuarioLogueo AND contrasenia = :contraseniaLogueo AND estado='activado';";

    $arrayUsuario = [
      "usuarioLogueo"=>$this->usuarioLogueo,
      "contraseniaLogueo"=>$this->contraseniaLogueo];

    $mysqlPDO = $conexion->prepare($sql);
    $respuesta = $mysqlPDO->execute($arrayUsuario);
    $usuarioLogueado = $mysqlPDO->fetchAll();

    
  
    return $usuarioLogueado;
    

  }

  

}



?>