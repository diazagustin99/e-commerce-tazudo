<?php
session_start();
require('conexion.php');
$respuesta = new stdClass();
$cantidadCarrito = 0;
if (!empty($_POST['idprod']) && !empty($_POST['cant'])) {
    $producto = new stdClass();
    $productoCarrito = new stdClass();
    $conexion = conectar();
    $resultado = mysqli_query($conexion, 'SELECT * FROM productos WHERE id_producto = \'' . trim($_POST['idprod']) . '\'');
    if (mysqli_num_rows($resultado)) {
        $row=mysqli_fetch_array($resultado);
        $producto->id_producto=$row['id_producto'];
        $producto->nombre=$row['nombre'];
        $producto->descripcion=$row['descripcion'];
        $producto->precio_menor=$row['precio_menor'];
        $producto->precio_oferta=$row['precio_oferta'];
        $producto->estado_oferta=$row['estado_oferta'];
        $producto->estado=$row['estado'];
        $producto->destacado=$row['destacado'];
        $producto->categoria=$row['categoria'];
        $producto->imagenes[0]=$row['foto1'];
        $productoCarrito->producto=$producto;
        $productoCarrito->cantidad= intval($_POST['cant']);
        if (isset($_SESSION['carrito'])) {
            $arreglo = $_SESSION['carrito'];
            $bandera = 0;
            foreach ($arreglo as $productoArray) {
                if ($productoArray->producto->id_producto == $productoCarrito->producto->id_producto) {
                    $productoArray->cantidad = $productoArray->cantidad + $productoCarrito->cantidad;
                    $bandera++;
                    break;
                }
            }
            if ($bandera == 0) {
                $cant = count($arreglo);
                $arreglo[$cant]=$productoCarrito;
            }
            foreach ($arreglo as $value) {
                $cantidadCarrito= $cantidadCarrito + $value->cantidad;
            }

        }else {
            $arreglo[0]=$productoCarrito;
            $cantidadCarrito = $productoCarrito->cantidad;
        }
        $_SESSION['carrito']=$arreglo;
        $estado = array(
        "mensaje" => "Producto agregado",
        "codigo" => 200
        );
    }else {
        $estado = array(
        "mensaje" => "Producto no encontrado",
        "codigo" => 404
        );
    }
}else{
    $estado = array(
    "mensaje" => "No envio los parametros",
    "codigo" => 404
    );
}
$respuesta->estado= $estado;
$respuesta->countCarrito = $cantidadCarrito;
header('Content-Type: application/json');
echo json_encode($respuesta);
?>