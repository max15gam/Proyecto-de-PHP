<?php


$envio = "";
$codigo = "";
$usuario = "";
$mail = "";
$confirmacion = "";

//capturo campos
if(isset($_POST['generoCodigo'])){

  $codigo = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz",5)),0,10);
  
}

if(isset($_POST['usuario'])){

  $usuario = $_POST['usuario'];
  $usuario =str_replace(' ', '', $usuario); //elimino espacios en blanco dentro de la cadena de texto
  $usuario = filter_var($usuario, FILTER_SANITIZE_STRING); //evito inyecciones sql


  include("../configuracion/configuracion.php");

  $conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].":".$ARRAYCONFIGURACION['MySQL']['port'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbname'], $ARRAYCONFIGURACION['MySQL']['user'], $ARRAYCONFIGURACION['MySQL']['password']);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // ------ genero el código en la base de datos ------ \\
  $sql = "UPDATE clientes
  SET codigo = '$codigo'
  WHERE usuario = '$usuario';";

  $mysqlPDO = $conexion->prepare($sql);
  $respuesta = $mysqlPDO->execute();

  // ------ busco el correo que le corresponde al usuario ingresado y le envío el código ------ \\

  $sqlMail = "SELECT mail FROM clientes WHERE usuario = '$usuario';";

  $mysqlPDO = $conexion->prepare($sqlMail);
  $respuesta = $mysqlPDO->execute();
  $mailEncontrado = $mysqlPDO->fetchAll();

  foreach ($mailEncontrado as $clave) {
    $mail = $clave['mail'];
  }

  if( !empty($mail) ){
    
    $asunto = "No responda este mensaje - código de recuperación de cuenta";
    $msg = "Su código es: " . $codigo;

    $header = "From: automotoragambetta@gmail.com" . "\r\n";
    $header.= "Reply-To: automotoragambetta@gmail.com" . "\r\n";
    $header.= "X-Mailer: PHP/" . phpversion();
    $email = mail($mail,$asunto,$msg,$header);

  }else{
    $mail = "no existe usuario";
  }
  

  

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../web/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style>
    *{
      margin: 0;
      padding: 0;
    }
  .centrado {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  #btnVolver::before {  
  transform: scaleX(0);
  transform-origin: bottom right;
  }

  #btnVolver:hover::before {
    transform: scaleX(1);
    transform-origin: bottom left;
  }

  #btnVolver::before {
    content: " ";
    display: block;
    position: absolute;
    top: 0; right: 0; bottom: 0; left: 0;
    inset: 0 0 0 0;
    background: hsl(200 100% 80%);
    z-index: -1;
    transition: transform .5s ease;
  }
  
  </style>
  <title>Automotora Gambetta</title>
<body class="teal lighten-5">

<div class="center-align">
  <button id="btnVolver" onclick="location.href = '../index.php';" class="waves-effect waves-light transparent btn black-text" style="margin-top: 2em;">inicio
    <i class="material-icons right">keyboard_return</i>
  </button>
</div>

<div class="contenedor centrado card-panel z-depth-3">
    

    <div class="row" >
        <form class="col s12" action="reseteo_contrasenia.php" method="post">

          <div class="row">
            <div class="col s12 center">
             <p> Se generará un código para que pueda iniciar sesión.</p>
            </div>
            <div class="col s4 hide-on-med-and-down"></div>
            <div class="input-field col s12 l4">
              <input id="txtusuario" type="text" class="validate" name="usuario" required>
              <label for="txtusuario">Usuario</label>
            </div>
            <div class="col s12 center row">
            <?php     if($mail && $mail != "no existe usuario"){ 
            ?>
              <p class="green-text center">Enviado</p><i class="material-icons green-text">check_circle</i> 
            <?php     }elseif(empty($mail)){ 
            ?>
            
            <?php     }else{ 
            ?>
            <p class="red-text">Error, el usuario no existe</p><i class="material-icons red-text">cancel</i>
            <?php     } 
            ?>
            
            </div>
            <div class="input-field col s12 center">
              <input type="hidden" name="generoCodigo" value="enviado">
              <button type="submit" class="waves-effect waves-light blue darken-1 btn" >Enviar</button>
            </div>
            
          </div>
          
        </form>
    </div>

  </div>


  
  
  <script src="../web/js/jquery-2.1.1.js"></script>
  <script src="../web/js/materialize.js"></script>
  

</body>
</html>
