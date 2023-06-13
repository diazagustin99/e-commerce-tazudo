<?php
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
    $count = 0;
if (isset($_POST['idcat']) || isset($_POST['eOferta'])) {
    if (isset($_POST['idcat'])) {
        if ($_POST['idcat'] != '') {
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT * FROM productos WHERE categoria = \'' . $_POST['idcat']. '\'');
            if (mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_array($resultado)) {
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
                    $datos[$count]=$obj;
                    $count++;
                }
                desconectar($conexion);
                $estado = array(
                    "mensaje" => "Filtro exitoso.",
                    "codigo" => 200
                    );
            }else {
                $estado = array(
                    "mensaje" => "Filtro exitoso, no hay productos con esta categoria",
                    "codigo" => 200
                    );
            }
        }else {
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT * FROM productos');
            if (mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_array($resultado)) {
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
                    $datos[$count]=$obj;
                    $count++;
                }
                desconectar($conexion);
                $estado = array(
                    "mensaje" => "Filtro exitoso.",
                    "codigo" => 200
                    );
            }else {
                $estado = array(
                    "mensaje" => "Filtro exitoso, no hay productos con esta categoria",
                    "codigo" => 200
                    );
            }
        }

    }
    if (isset($_POST['eOferta']) == 1) {
        if (empty($datos)) {
            $conexion = conectar();
            $resultado = mysqli_query($conexion, 'SELECT * FROM productos WHERE estado_oferta = \'' . '1'. '\'');
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_array($resultado)) {
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
                    $datos[$count]=$obj;
                    $count++;
                }
                desconectar($conexion);
            }else {
                $estado = array(
                    "mensaje" => "Filtro exitoso, no hay productos en oferta",
                    "codigo" => 200
                    ); 
            }
        }else {
            $datos = array_filter($datos, 'filterOferta');
            $estado = array(
                "mensaje" => "Filtro exitoso, productos filtrados y en oferta",
                "codigo" => 200
                ); 
        }
    }
}else {
    $estado = array(
        "mensaje" => "ERROR: no envio categoria, ni confirmacion del filtro de oferta",
        "codigo" => 404
        ); 
}

$response->estado= $estado;
$response->datos = $datos;
header('Content-Type: application/json');
echo json_encode($response);

function filterOferta($value){
    return $value->estado_oferta == 1;
}
?>