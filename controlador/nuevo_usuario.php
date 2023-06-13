<?php
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header("refresh:0;url=usuario.php");
            exit();
        }
    require("conexion.php");
if (!empty($_POST['usuario']) && !empty($_POST['pass']) && !empty($_POST['rol']) && !empty($_POST['email'])) {
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $clave = sha1(trim($_POST['pass']));
    $rol = trim($_POST['rol']);


    $conexion = conectar();
    $resultado = mysqli_query($conexion, 'INSERT INTO usuarios (usuario, password, rol, email) VALUES (\''.$usuario.'\', \''.$clave.'\', \''. $rol .'\', \''. $email .'\')');
    desconectar($conexion);
    header("refresh:0;url=usuarios.php");
    }else {
        header("refresh:0;url=usuarios.php");
    }
        
?>