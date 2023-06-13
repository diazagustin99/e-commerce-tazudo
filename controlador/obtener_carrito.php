<?php
session_start();
require('conexion.php');
$respuesta = new stdClass();
$carrito = array();
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    $estado = array(
        "mensaje" => "Carrito con productos",
        "codigo" => 200
        );
    $carrito = $_SESSION['carrito']; 
}else {
    $estado = array(
        "mensaje" => "Carrito vacio :(",
        "codigo" => 400
        );
}
$respuesta->estado= $estado;
$respuesta->carrito = $carrito;
header('Content-Type: application/json');
echo json_encode($respuesta);
?>