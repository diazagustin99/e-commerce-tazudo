<?php
    session_start();
    require("conexion.php");
    $response = new stdClass();
    $countCarrito = 0;
    if (isset($_SESSION['carrito']) && !empty($_POST['idprod']) && $_POST['cantidad'] >= 0) {
        $carrito = $_SESSION['carrito'];
        $nuevoCarrito = array();
        if ($_POST['cantidad'] == 0) {
            foreach ($carrito as $value) {
                if ($value->producto->id_producto != trim($_POST['idprod'])) {
                    array_push($nuevoCarrito, $value); 
                    $countCarrito = $countCarrito + $value->cantidad;
                }
             }
             $_SESSION['carrito']= $nuevoCarrito;
             $response->estado = array(
                'codigo' => 200,
                'mensaje' => 'Se Borro el producto del carrito',
                'countCarrito' =>$countCarrito
            );
        }
        else {
            foreach ($carrito as $value) {
                if ($value->producto->id_producto === trim($_POST['idprod'])) {
                       $value->cantidad = $_POST['cantidad'];
                }
                $countCarrito =$countCarrito + $value->cantidad;
             }
             $_SESSION['carrito']= $carrito;
             $response->estado = array(
                'codigo' => 200,
                'mensaje' => 'Se actualizo la cantidad.',
                'countCarrito' =>$countCarrito
            );
        }
        
        $response->carrito=$_SESSION['carrito'];
    }else {
        $response->estado = array(
            'codigo' => 400,
            'mensaje' => 'Los datos enviados son incorrectos.'
        );
        $response->carrito=$_SESSION['carrito'];
    }
    header('Content-Type: application/json');
    echo json_encode($response);
?>