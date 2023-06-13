<?php
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
        $conexion = conectar();
        $resultado = mysqli_query($conexion, 'SELECT * FROM categorias');
        $rowCat = mysqli_fetch_array($resultado);
        while ($rowCat = mysqli_fetch_array($resultado)) {
            $contador = 0;
            $obj = new stdClass();
            $obj->id_producto=$row['id_categoria'];
            $obj->nombre=$row['nombre_categoria'];
            $obj->descripcion=$row['foto_categoria'];
            $datos[$contador]=$obj;
            $contador++;
        }
        desconectar($conexion);
        $response->datos=$datos;
        header('Content-Type: application/json');
        echo json_encode($response);
?>