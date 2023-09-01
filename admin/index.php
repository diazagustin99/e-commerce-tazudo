<?php
$ruta='../css';
session_start();
if (!empty($_SESSION['usuario'])) {
    header("refresh:0;url=pages/productos.php");
    exit();
}
require_once("vista/modulos/header-admin.php");
require_once("../controlador/conexion.php");
?>

 <main class="main-sesion">
 <div class="notification" id="body-not">
        <span class="close-btn" onclick="closeNotification()">&times;</span>
        <h3 id="h3-not">Notificación</h3>
        <p id="text-not">Esta es una notificación flotante.</p>
    </div>

     <section class="contenedor-form-sesion">
         <section class="form-sesion">
             <label class="label-form" for="user">Usuario o email</label>
             <input class="input-form" type="text" name="usuario" id="user" placeholder="Ingrese aqui...">
             <label class="label-form" for="pass">Clave</label>

             <div class="password-container">
                <input class="input-form" type="password" name="pass" id="password" placeholder="Ingrese aqui...">
                <button id="toggle-password" onclick="togglePasswordVisibility()">
                    Mostrar
                </button>
            </div>
             <button class="btn-confirmar" id="btn-sesion">Iniciar Sesion</button>
         </section>
 </main>

 <script src="js/iniciar-sesion.js"></script>

</section>