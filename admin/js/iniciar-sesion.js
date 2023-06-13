const labelUser = document.getElementById('user');
const labelPass = document.getElementById('password');
const btnSesion = document.getElementById('btn-sesion');
var notification = document.querySelector('.notification');
const h3not = document.getElementById('h3-not');
const bodyNot = document.getElementById('text-not');
btnSesion.addEventListener("click", ()=>{
    let user = labelUser.value;
    let pass = labelPass.value;
    $.ajax({
        url: '../controlador/iniciar_sesion.php',
        type: 'POST',
        data: {
          usuario: user,
          pass: pass
        },
        success: function (response) {
          console.log(response.datos);
          console.log(response.datos[0]['estado']);
          if (response.datos[0]['estado'] == 'TRUE') {
            h3not.innerHTML = 'Inicio de sesion correcto';
            notification.style.backgroundColor = 'green';
            bodyNot.innerHTML = 'Ahora sera redirigido al panel.';
            notification.style.display ='block';
            setTimeout(function() {
                closeNotification();
                window.location.href = 'pages/productos.php';
            }, 2000);
          }else{
            h3not.innerHTML = 'Inicio de sesion incorrecto';
            notification.style.backgroundColor = 'red';
            bodyNot.innerHTML = 'Revise las credenciales.';
            notification.style.display ='block';
            setTimeout(function() {
                closeNotification();
            }, 2000);
          }
        },
        error: function (response) {
          console.log(response);
        }
      });
})

function closeNotification() {
    notification.style.display = 'none';
}

// Cerrar la notificación después de 2 segundos

function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var toggleButton = document.getElementById("toggle-password");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleButton.textContent = "Ocultar";
  } else {
    passwordInput.type = "password";
    toggleButton.textContent = "Mostrar";
  }
}
