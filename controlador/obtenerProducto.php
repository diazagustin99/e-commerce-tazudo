<?php
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
    if (!empty($_POST['id'])) {
        $conexion = conectar();
        $resultado = mysqli_query($conexion, 'SELECT * FROM productos WHERE id_producto = \'' . $_POST['id'] . '\'');
        $row=mysqli_fetch_array($resultado);
        $resultado = mysqli_query($conexion, 'SELECT nombre_categoria FROM categorias WHERE id_categoria = \'' . $row['categoria'] . '\'');
        $rowCat = mysqli_fetch_array($resultado);
            $obj = new stdClass();
            $obj->id_producto=$row['id_producto'];
            $obj->nombre=$row['nombre'];
            $obj->descripcion=$row['descripcion'];
            $obj->precio_menor=$row['precio_menor'];
            $obj->precio_oferta=$row['precio_oferta'];
            $obj->estado_oferta=$row['estado_oferta'];
            $obj->estado=$row['estado'];
            $obj->destacado=$row['destacado'];
            $obj->categoria=$row['categoria'];
            $obj->imagenes[0]=$row['foto1'];
            $obj->imagenes[1]=$row['foto2'];
            $obj->imagenes[2]=$row['foto3'];
            $datos[0]=$obj;
        desconectar($conexion);
        $response->datos=$datos;
        header('Content-Type: application/json');
        echo json_encode($response);
    }else {
        $datos[0]="No envio un ID de producto";
       $response->datos=$datos;
       header('Content-Type: application/json');
       echo json_encode($response);
    }
?>

