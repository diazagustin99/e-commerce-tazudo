<?php
session_start();
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("refresh:0;url=../index.php");
    exit();
}
$ruta = '../css';
$rutaImg = '../img/productos/';
require("conexion.php");


    if (!empty($_GET['id'])) {
        $id = trim($_GET['id']);
        $conexion = conectar();
        if ($conexion) {
            $respuesta = mysqli_query($conexion, 'SELECT foto1, foto2, foto3 FROM productos WHERE id_producto = \'' . $id . '\'');
            $respuestaDelate = mysqli_query($conexion, 'DELETE FROM productos WHERE id_producto = \'' . $id . '\'');
            if ($respuestaDelate) {
                if (mysqli_num_rows($respuesta) > 0) {
                   $filaFoto = mysqli_fetch_array($respuesta);
                   for ($i=0; $i <= 2; $i++) { 
                        if (isset($filaFoto[$i]) || !empty($filaFoto[$i])) {
                            unlink($rutaImg.$filaFoto[$i]);
                        }
                   }

                }
            }   
        }
        desconectar($conexion);
    }
header("refresh:0;url=../admin/pages/productos.php");
?>