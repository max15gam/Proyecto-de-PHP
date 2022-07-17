
/* -----------------------------------------------------------
 ----------------scripts para los modals----------------------
 ------------------------------------------------------------- */

$(document).ready(function(){

  $('.modal').modal();
//creo un modal para avisar al usuario que se registre para operar en la página
  setTimeout(function() { 
    $('#modalAvisoRegistro').modal();
    $('#modalAvisoRegistro').modal('open'); 
  }, 6000);

  


  $('select').formSelect(); //para activar el input select
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd' });


 

});

// script para invalidar letras en el campo de teléfono en registro de clientes
function validate(evt) {
  var theEvent = evt || window.event;

  
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}


// creo funciones para ocultar contraseñas en los inputs de logueo y registro

function ocultarContraseniaLogueo() {
  var idDelInput = document.getElementById("txtContrasenia");
  if (idDelInput.type === "password") {
    idDelInput.type = "text";
  } else {
    idDelInput.type = "password";
  }
}

function ocultarContraseniaRegistro() {
  var idDelInput = document.getElementById("txtRegContrasenia");
  if (idDelInput.type === "password") {
    idDelInput.type = "text";
  } else {
    idDelInput.type = "password";
  }
}

function ocultarContraseniaCambio() {
  var idDelInput = document.getElementById("txtCambioContrasenia");
  if (idDelInput.type === "password") {
    idDelInput.type = "text";
  } else {
    idDelInput.type = "password";
  }
}




    

/* ------------------------------------------------------------------------------------------------
 ----------------scripts para ocultar y mostrar divs en gestion de usuario-------------------------
 -------------------------------------------------------------------------------------------------- */

//ocultar todos los botones y los divs

// document.getElementById("myDIV").style.display = "none";
// document.getElementsByClassName("example");
function ocultarTodoGestionUsuario(){

  document.getElementById("divListadoAlquileres").style.display = "none";
  document.getElementById("divListadoClientes").style.display = "none";
  document.getElementById("divListadoEncargados").style.display = "none";
  document.getElementById("divListadoVendedores").style.display = "none";
  document.getElementById("divIngresoAlquileres").style.display = "none";
  document.getElementById("divIngresoVehiculos").style.display = "none";
  document.getElementById("divIngresoUsuarios").style.display = "none";
  document.getElementById("divListadoVehiculos").style.display = "none";
  document.getElementById("divListadoCorreos").style.display = "none";
}

function mostrarDivIngresoAlquileres(){
  ocultarTodoGestionUsuario();
  document.getElementById("divIngresoAlquileres").style.display = "block";
}

function mostrarDivIngresoVehiculos(){
  ocultarTodoGestionUsuario();
  document.getElementById("divIngresoVehiculos").style.display = "block";
}

function mostrarDivIngresoUsuarios(){
  ocultarTodoGestionUsuario();
  document.getElementById("divIngresoUsuarios").style.display = "block";
}

function mostrarDivListadoAlquileres(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoAlquileres").style.display = "block";
}

function mostrarDivListadoClientes(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoClientes").style.display = "block";
}

function mostrarDivListadoVehiculos(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoVehiculos").style.display = "block";
}

function mostrarDivListadoEncargados(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoEncargados").style.display = "block";
}

function mostrarDivListadoVendedores(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoVendedores").style.display = "block";
}

function mostrarDivListadoCorreos(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoCorreos").style.display = "block";
}



