<?php
function conectar(){
    $servidor = 'localhost';
    $usuario = 'root';
    $clave = '';
    $db = 'tazudo_bd';
    $conexion = mysqli_connect($servidor, $usuario, $clave, $db);
    if (!$conexion) {
        echo '<p> Error al conectar </p>';
    }else {
        return($conexion);
    }
}


function desconectar($conexion){
    if ($conexion) {
        $desco = mysqli_close($conexion);
        if (!$desco) {
            echo '<p> Error al intentar desconectar </p>';
        }
    }else {
        echo '<p> No se puede desconectar, no existe conexion </p>';
    }
}

?>