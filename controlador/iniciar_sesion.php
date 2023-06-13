<?php

session_start();
require('conexion.php');
$bandera = 0;
$response = new stdClass();
$obj = new stdClass();
$obj->estado= 'FALSE';
$datos = [];
if (!empty($_POST['usuario']) && !empty($_POST['pass'])) {
    $usuario = trim($_POST['usuario']);
    $clave = sha1(trim($_POST['pass']));
    if (strpos($usuario, '@')=== false) {
        $conexion = conectar();
        $resultado = mysqli_query($conexion, ' SELECT rol, email, id_usuario  FROM usuarios WHERE usuario =  \'' . $usuario . '\' AND password = \''. $clave . '\' ');
            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_array($resultado);
                $_SESSION['id_usuario'] = $fila[2];
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $fila[0];
                $_SESSION['email'] = $fila[1];
                $obj->estado= 'TRUE';
                $obj->user= $_SESSION['usuario'];
            }
            desconectar($conexion);
    }else{
        $conexion = conectar();
        $resultado = mysqli_query($conexion, ' SELECT rol, usuario, id_usuario FROM usuarios WHERE email =  \'' . $usuario . '\' AND password = \''. $clave . '\' ');
            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_array($resultado);
                $_SESSION['id_usuario'] = $fila[2];
                $_SESSION['usuario'] = $fila[1];
                $_SESSION['rol'] = $fila[0];
                $_SESSION['email'] = $usuario;
                $obj->estado= 'TRUE';
                $obj->user= $_SESSION['usuario'];
            }
            desconectar($conexion);
    }
    }
    $datos[0]=$obj;
    $response->datos=$datos; 
    header('Content-Type: application/json');
    echo json_encode($response);
?>