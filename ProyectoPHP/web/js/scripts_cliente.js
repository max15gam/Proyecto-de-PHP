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


//para hacer visible las contraseñas
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



//OCULTO O MUESTRO DIVS

function ocultarTodosLosDivs(){

  document.getElementById("divListaBmw").style.display = "none";
  document.getElementById("divListaFord").style.display = "none";
  document.getElementById("divListaToyota").style.display = "none";
  document.getElementById("divListaVolkswagen").style.display = "none";
  

  
}


function mostrarDivBmw(){
  ocultarTodosLosDivs();
  document.getElementById("divListaBmw").style.display = "block";
}

function mostrarDivFord(){
  ocultarTodosLosDivs();
  document.getElementById("divListaFord").style.display = "block";
}

function mostrarDivToyota(){
  ocultarTodosLosDivs();
  document.getElementById("divListaToyota").style.display = "block";
}

function mostrarDivVolkswagen(){
  ocultarTodosLosDivs();
  document.getElementById("divListaVolkswagen").style.display = "block";
}


function mostrardivUtilitariosMitsubishi(){

  document.getElementById("divUtilitariosNewHolland").style.display = "none";
  document.getElementById("divUtilitariosMitsubishi").style.display = "block";
  
  
}

function mostrardivUtilitariosNewHolland(){
  
  document.getElementById("divUtilitariosMitsubishi").style.display = "none";
  document.getElementById("divUtilitariosNewHolland").style.display = "block";
  
}