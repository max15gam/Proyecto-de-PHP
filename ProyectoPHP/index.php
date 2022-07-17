<?php
session_start();
require_once("modelos/registroClientes.php");
require_once("modelos/login.php");



//FUNCION DE LOGUEO CUANDO RECIBO POR POST LOS DATOS DEL USUARIO
if(isset($_POST['txtUsuarioLogueo']) && isset($_POST['txtContraseniaLogueo'])){
  $usuarioLogueo = $_POST['txtUsuarioLogueo'];
  $contraseniaLogueo = $_POST['txtContraseniaLogueo'];

  $objLogin = new Login();

  $usuarioContrasenia = ["usuarioLogueo"=>$usuarioLogueo,"contraseniaLogueo"=>$contraseniaLogueo];

  $objLogin->constructor($usuarioContrasenia);

  $objLogin->iniciarSesion();

  $usuarioLogueado = $objLogin->iniciarSesion();

  //asigno variables session cuando se loguea
  foreach ($usuarioLogueado as $item) {
    $_SESSION['id'] = $item['id'];
    $_SESSION['usuario'] = $item['usuario'];
    $_SESSION['contrasenia'] = $item['contrasenia'];
    $_SESSION['nombre'] = $item['nombre'];
    $_SESSION['apellido'] = $item['apellido'];
    $_SESSION['mail'] = $item['mail'];
    $_SESSION['documento_o_tipoUsuario'] = $item['documento_o_tipoUsuario'];
    $_SESSION['horaDeInicio'] = date("Y-m-d H:i:s");
    session_write_close();
  }

  //redirecciono según corresponda, si ningún usuario fue logueado emite mensaje de error y vuelve a página principal
  if (isset($_SESSION['usuario'])) {

    switch ($_SESSION['documento_o_tipoUsuario']) {
      case 'administrador':
        header('Location: backend/interfaz_administrador.php');
        exit();
        break;
      case 'encargado':
        header('Location: backend/interfaz_encargado.php');
        exit();
        break;
      case 'vendedor':
        header('Location: backend/interfaz_vendedor.php');
        exit();
        break;
      default:
        header('Location: backend/interfaz_cliente.php');
        exit();
      break;
    }

    
  }else {
    header('Location: index.php?loginerror=1');
  }
}

$nombre = "";
$apellido = "";
$direccion = "";
$telefono = "";
$mail = "";
$usuario = "";
$contrasenia = "";
$tipoDocumento = "";
$documento = "";
    

//--------------capturo campos----------------\\
  if(isset($_POST['registroNombre'])){

    $nombre = $_POST['registroNombre'];
    $nombre = trim($nombre); //quito espacios en blanco antes y después del texto ingresado

  }

  if(isset($_POST['registroApellido'])){

    $apellido = $_POST['registroApellido'];
    $apellido = trim($apellido);

  }

  if(isset($_POST['registroDireccion'])){

    $direccion = $_POST['registroDireccion'];
    $apellido = trim($apellido);

  }

  if(isset($_POST['registroTelefono'])){

    $telefono = $_POST['registroTelefono'];
    
  }

  if(isset($_POST['registroMail'])){

    $mail = $_POST['registroMail'];
     
    
  }

  if(isset($_POST['registroUsuario'])){

    $usuario = $_POST['registroUsuario'];
    $usuario =str_replace(' ', '', $usuario); //elimino espacios en blanco dentro de la cadena de texto

  }

  if(isset($_POST['registroContrasenia'])){

    $contrasenia = $_POST['registroContrasenia'];
   
  }

  if(isset($_POST['registroTipoDeDocumento'])){

    $tipoDocumento = $_POST['registroTipoDeDocumento'];

  }

  if(isset($_POST['registroDocumento'])){

    $documento = $_POST['registroDocumento'];
    $documento =str_replace(' ', '', $documento); //elimino espacios en blanco dentro de la cadena de texto
  }

//-----------------------------------------------------\\




if(isset($_POST['btnRegistrarCliente'])){

   
//-----------------verifico que los campos no estén vacíos----------------------\\

  if(empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono) || empty($mail) || 
     empty($usuario) || empty($contrasenia) || empty($tipoDocumento) || empty($documento) ){

      $nombre = "";
      $apellido = "";
      $direccion = "";
      $telefono = "";
      $mail = "";
      $usuario = "";
      $contrasenia = "";
      $tipoDocumento = "";
      $documento = "";

      
     }else{

      
      // en caso que no estén vacíos permito instanciar objeto

      $objCliente = new Cliente();

      $datos = ["nombre"=>$nombre,"apellido"=>$apellido,"direccion"=>$direccion,"telefono"=>$telefono,"mail"=>$mail,"usuario"=>$usuario,
      "contrasenia"=>$contrasenia,"tipoDocumento"=>$tipoDocumento,"documento"=>$documento,"estado"=>"activado","codigo"=>NULL];

      $objCliente->constructor($datos);

      $objCliente->crearCliente();

      $nombre = "";
      $apellido = "";
      $direccion = "";
      $telefono = "";
      $mail = "";
      $usuario = "";
      $contrasenia = "";
      $tipoDocumento = "";
      $documento = "";

    
      header('Location: index.php');                                        

     }
  

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
  <link href="web/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="web/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="web/css/estilos.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
</head>
<body>



  <!-- COMIENZA EL NAV -->
  <nav class="navbar-fixed transparent z-depth-0" role="navigation">
    <div class="nav-wrapper container">
      <div id="logo-container" class="brand-logo">
      
      <img id="imgLogo" class="responsive-img hide-on-med-and-down" src="web/img/carNow.svg" alt="">
      
      </div>
      
      <ul class="right hide-on-med-and-down">
        <li><a class="intermitente modal-trigger" id="txtIniciarSesion" href="#modalInicioDeSesion">Iniciar sesión</a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li><a class="intermitente btn modal-trigger grey darken-4" href="#modalInicioDeSesion">Iniciar sesión</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <!-- FIN DEL NAV -->



  <!-- COMIENZA BANNER -->
  <div class="section no-pad-bot" id="index-banner">
    
    <div id="centroHeader" class="container">
  
      <div class="header center">
          <img class="responsive-img hide-on-med-and-up" src="web/img/carNow.svg" alt="">
      </div>

    </div> 
      
  </div>
  
<!-- FIN BANNER -->

<!-- 
-----------------------------------------------------------------------------------------------------
-------------------------------------MODALS----------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-->



<!-- Modal aviso para registrarse -->
<div id="modalAvisoRegistro" class="modal">
  <div class="modal-content">
    <div class="container">
      <div class="row">

        <div class="col s2">
          <i class="material-icons right">info</i>
        </div>
        <div class="col s10">
          <p><strong>¡Registrate para ya mismo realizar tu alquiler! </strong></p>
        </div>

        <div class="col s12 center">
          <a class="modal-close waves-effect waves-light btn grey darken-1 modal-trigger" href="#modalRegistroDeCliente">Registrarse</a>
        </div>

      </div>
    </div>
  </div>
  <div class="modal-footer blue-grey lighten-4">
    <a href="#!" class="modal-close waves-effect waves-black btn-flat">Cerrar</a>
  </div>
</div>

<!-- Modal inicio de sesión -->
<div id="modalInicioDeSesion" class="modal">
  <div class="modal-content">
    <div class="container">
      <div class="row">
        
        <form class="col s12" action="index.php" method="post">
          <div class="row">
            
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="Usuario" type="text" class="validate" name="txtUsuarioLogueo" required>
              <label for="Usuario">Usuario</label>
            </div>
            
            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="txtContrasenia" type="password" class="validate" name="txtContraseniaLogueo" required>
              <label for="txtContrasenia">Contraseña</label>
              <i onclick="ocultarContraseniaLogueo()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
            </div>
            
            <div class="row">
              <div class="col s6">
                <button class="btn waves-effect waves-light grey darken-1" type="submit" name="action">Ingresar
                  <i class="material-icons right">send</i>
                </button>
              </div>
              <div class="col s6 right-align">
                  <a class="blue-text modal-close modal-trigger" href="#modalRegistroDeCliente">Registrarse</a>
              </div>
            </div>
            <div class="col s12 center-align">
                  <a class="blue-text" onClick="document.location.href='backend/reseteo_contrasenia.php'" style="cursor: pointer;">¿Olvidaste la contraseña?</a>
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

<!-- Modal de registro de cliente -->
<div id="modalRegistroDeCliente" class="modal">
  <div class="modal-content">
    <div class="container">
      <div class="row">

        <form class="col s12" action="index.php" method="post">
          <div class="row">

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="txtNombre" type="text" class="validate" name="registroNombre" required>
              <label for="txtNombre">Nombre</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="txtApellido" type="text" class="validate" name="registroApellido" required>
              <label for="txtApellido">Apellido</label>
            </div>
           
            <div class="input-field col m6">
              <i class="material-icons prefix">home</i>
              <input id="txtDireccion" type="text" class="validate" name="registroDireccion" required>
              <label for="txtDireccion">Dirección</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">call</i>
              <input id="txtTelefono" type="text" class="validate" onkeypress='validate(event)' name="registroTelefono" required>
              <label for="txtTelefono">Telefono</label>
            </div>

            <div class="input-field col s12">
              <i class="material-icons prefix">email</i>
              <input id="txtEmail" type="email" class="validate" name="registroMail" required>
              <label for="txtEmail">Email</label>
            </div>
 
            <div class="input-field col m6">
              <select id="txtTipoDeDocumento" name="registroTipoDeDocumento" required>
                <option value="cedula">CI</option>
                <option value="credencial">Credencial</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="otro">Otro</option>
              </select>
              <label for="txtTipoDeDocumento">Tipo de documento</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">public</i>
              <input id="txtDocumento" type="text" class="validate" name="registroDocumento" required>
              <label for="txtDocumento">Documento</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">account_circle</i>
              <input id="txtUsuario" type="text" class="validate" name="registroUsuario" required>
              <label for="txtUsuario">Usuario</label>
            </div>

            <div class="input-field col m6">
              <i class="material-icons prefix">lock</i>
              <input id="txtRegContrasenia" type="password" class="validate" name="registroContrasenia" required>
              <label for="txtRegContrasenia">Contraseña</label>
              <i onclick="ocultarContraseniaRegistro()" class="material-icons prefix" style="cursor: pointer;">visibility</i>
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



 <!--  Sección informativa   -->
  <div id="idSecciones" class="container">
    <div class="section">
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">credit_card</i></h2>
            <h5 class="center">Garantías de depósito</h5>

            <p class="light">Montos bajos donde además contará con beneficios especiales. Descuentos, regalos y mucho más</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">verified_user</i></h2>
            <h5 class="center">Menos requisitos</h5>

            <p class="light">A diferencia de otras automotoras podrá gozar de todas nuestras flotas con tan solo unos pocos datos</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">location_searching</i></h2>
            <h5 class="center">Localización</h5>

            <p class="light">Contamos con un servicio especial de localización gps que podrá solicitar sin costo para situaciones de emergencia</p>
          </div>
        </div>
      </div>

    </div>
    <br><br>
  </div>
 <!--  Comienza el footer   -->
  <footer class="page-footer grey">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Sobre nosotros</h5>
          <p class="grey-text text-lighten-4">
            Comenzamos como una empresa dedicada al alquiler especificamente de automóviles. Hoy dada la 
            demanda en la industria también ofrecemos alquiler de vehículos utilitarios, etc.
          </p>
          

        </div>
        <div class="col l6 s12">
          
          <ul class="row">
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/ford-logo-vector-01.png" alt=""></li>
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/bmw-flat-logo.png" alt=""></li>
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/toyota-logo-vector.png" alt=""></li>
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/volkswagen-auto-vector-logo.png" alt=""></li>
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/mitsubishi-forklift-trucks-vector-logo.png" alt=""></li>
            <li class="imgFooter col s2"><img class="responsive-img" src="web/img/new-holland-vector-logo.png" alt=""></li>
            
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        Hecho con <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  
  <script src="web/js/jquery-2.1.1.js"></script>
  <script src="web/js/materialize.js"></script>
  <script src="web/js/init.js"></script>
  <script src="web/js/scripts.js"></script>
  
  
  

  </body>


  
</html>

<?php
$usuarioLogueo = "";
$contraseniaLogueo = "";
$usuarioContrasenia = array();
    


  
  
  foreach($_SESSION as $i => $v){
    unset($_SESSION[$i]);
  }
  

  
  
 
  

?>