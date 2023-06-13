<?php
session_start();
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("refresh:0;url=../index.php");
    exit();
}
$ruta = '../css';
$rutaImg = '../img/categorias/';
require("conexion.php");

    if (!empty($_GET['id'])) {
        $id = trim($_GET['id']);
        $conexion = conectar();
        if ($conexion) {
            $respuesta = mysqli_query($conexion, 'SELECT foto_categoria FROM categorias WHERE id_categoria = \'' . $id . '\'');
            $respuestaDelate = mysqli_query($conexion, 'DELETE FROM categorias WHERE id_categoria = \'' . $id . '\'');
            if ($respuestaDelate) {
                if (mysqli_num_rows($respuesta) > 0) {
                   $filaFoto = mysqli_fetch_array($respuesta);
                   for ($i=0; $i <= sizeof($filaFoto) ; $i++) { 
                        if (isset($filaFoto[$i]) || !empty($filaFoto[$i])) {
                            unlink($rutaImg.$filaFoto[$i]);
                        }
                   }

                }
            }   
        }
        desconectar($conexion);
    }
header("refresh:0;url=../admin/pages/categorias.php");
?>