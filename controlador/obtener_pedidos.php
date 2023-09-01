<?php
    session_start();
    if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
        header("refresh:0;url=../index.php");
        exit();
    }
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
    $contador = 0;
        $conexion = conectar();
        $resultado = mysqli_query($conexion, 'SELECT p.*, SUM(d.cantidad * d.precio_unidad) AS total_pedido, SUM(d.cantidad) AS cantidad_articulos
        FROM pedidos p
        INNER JOIN detalle_pedidos d ON p.id_pedido = d.id_pedido
        GROUP BY p.id_pedido ORDER BY p.fecha_pedido DESC');
        $rowPed = mysqli_fetch_array($resultado);
        while ($rowPed = mysqli_fetch_array($resultado)) {
            $pedido = new stdClass();
            $pedido->id_pedido= $rowPed['id_pedido'];
            $pedido->fecha_pedido=$rowPed['fecha_pedido'];
            $pedido->medioPago=$rowPed['medio_pago'];
            $pedido->metEntrega=$rowPed['met_entrega'];
            $pedido->direEntrega= $rowPed['direccion_entrega'];
            $pedido->recargo= $rowPed['recargo'];
            $pedido->subtotal=$rowPed['total_pedido'];
            $pedido->total= $pedido->recargo + $pedido->subtotal;
            $pedido->cant_articulos=$rowPed['cantidad_articulos'];
            $pedido->estado_pedido= $rowPed['estado_pedido'];
            $pedido->estado_pago= $rowPed['estado_pago'];
            $datos[$contador]=$pedido;
            $contador++;
        }
        desconectar($conexion);
        $response->datos=$datos;
        header('Content-Type: application/json');
        echo json_encode($response);
?>