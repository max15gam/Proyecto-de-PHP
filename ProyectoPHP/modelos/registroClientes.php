<?php 

require_once("generico.php");

$Clientes = array();

class Cliente extends Usuario{

  private $direccion; 
  private $telefono; 
  private $tipoDocumento;
  private $documento;
  private $codigo;

  public function constructor($arrayDatos = array()){
    
    parent::constructor($arrayDatos);

    $this->direccion = $arrayDatos['direccion'];
    $this->telefono = $arrayDatos['telefono'];
    $this->tipoDocumento = $arrayDatos['tipoDocumento'];
    $this->documento = $arrayDatos['documento'];
    $this->codigo = $arrayDatos['codigo'];
    
  }

  public function crearCliente(){

    include("configuracion/configuracion.php");

    $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //genero la sentencia para agregar un nuevo cliente
    $sql = "INSERT INTO clientes SET 
              nombre = :nombre,
              apellido = :apellido,
              direccion = :direccion,
              telefono = :telefono,
              mail = :mail,
              usuario = :usuario,
              contrasenia = :contrasenia,
              tipoDocumento = :tipoDocumento,
              documento = :documento,
              estado = :estado,
              codigo = :codigo;";
    
    $arrayCliente = [
              "nombre"=>$this->nombre,
              "apellido"=>$this->apellido,
              "direccion"=>$this->direccion,
              "telefono"=>$this->telefono,
              "mail"=>$this->mail,
              "usuario"=>$this->usuario,
              "contrasenia"=>$this->contrasenia,
              "tipoDocumento"=>$this->tipoDocumento,
              "documento"=>$this->documento,
              "estado"=>$this->estado,
              "codigo"=>$this->codigo
      ];
    


          //-------------------------\\
        //---------CONTROLES----------\\
      //--------------------------------\\

       
    $listaPorUsuarioMail = $this->listaPorUsuarioMail(); //cargo lista por usuarios y mail
    $listaClientes = $this->listaClientes(); //cargo lista de clientes para controlar documentos

    // banderas
    $mailOk = false;
    $usuarioOk = false;
    $documentoOk = false;
    
    

    //---------------------------------------------------------------------------------------------------
    //---------------- controlo si existe el mail, de existir interrumpo el proceso----------------------
    foreach ($listaPorUsuarioMail as $valorMail) {
      if($valorMail['mail'] === $arrayCliente["mail"]){
        $mailOk = false;
        break;  
      }else{
        $mailOk = true;
      }
    }
    //----------------------------------------------------------------------------------------------------
    //---------------- controlo si existe el usuario, de existir interrumpo el proceso----------------------
    foreach ($listaPorUsuarioMail as $valorUsuario) {
      if($valorUsuario['usuario'] === $arrayCliente["usuario"]){
        $usuarioOk = false;
        break;  
      }else{
        $usuarioOk = true;
      }
    }

    //----------------------------------------------------------------------------------------------------
    //---------------- controlo si coincide tipo documento con el documento-------------------------------
    
    $varTipoDocumento = $arrayCliente["tipoDocumento"];
    $varDocumento = $arrayCliente["documento"];
    $tipoDocumentoYdocumento = "{$varTipoDocumento}{$varDocumento}";  //concatenados el tipo de documento y documento ingresado
    $arrayDocumentos = array(); // array vacio para poner las clave-valor concatenadas de tipo de documento y documento
    foreach ($listaClientes as $item) {
      array_push($arrayDocumentos,$item['tipoDocumento'].$item['documento']);
      
    } 
    

    $length = count($arrayDocumentos); // cuento la cantidad que hay en el array para tener el length del for

    for ($i=0; $i < $length ; $i++) { 
      if($arrayDocumentos[$i] === $tipoDocumentoYdocumento){
        $documentoOk = false;
        break;  
      }else{
        $documentoOk = true;
      }
      
    }


    if($mailOk == true  && $usuarioOk == true && $documentoOk == true ){
      $retorno = $this->ejecutarSentencia($sql,$arrayCliente);
      return $retorno;
    }

    

    

  }


  

}





?>