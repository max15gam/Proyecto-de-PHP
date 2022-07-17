
/* -----------------------------------------------------------
 ----------------scripts para los modals----------------------
 ------------------------------------------------------------- */

 $(document).ready(function(){

  $('.modal').modal();

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

function mostrarError(){
  if(errorMSG !== ''){
    $('#modalError').modal();
    $('#modalError').modal('open'); 
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
  document.getElementById("divIngresoAlquileres").style.display = "none";
}

function mostrarDivIngresoAlquileres(){
  ocultarTodoGestionUsuario();
  document.getElementById("divIngresoAlquileres").style.display = "block";
}

function mostrarDivListadoAlquileres(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoAlquileres").style.display = "block";
}

function mostrarDivListadoClientes(){
  ocultarTodoGestionUsuario();
  document.getElementById("divListadoClientes").style.display = "block";
}










