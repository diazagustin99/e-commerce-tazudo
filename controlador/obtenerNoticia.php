<?php
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
    if (!empty($_POST['id'])) {
        $conexion = conectar();
        $resultado = mysqli_query($conexion, 'SELECT * FROM noticias WHERE id_noticia = \'' . $_POST['id'] . '\'');
        $row=mysqli_fetch_array($resultado);
        if (!empty($row)) {
            $obj = new stdClass();
            $obj->id_noticia=$row['id_noticia'];
            $obj->nombre_noticia=$row['nombre_noticia'];
            $obj->estado=$row['estado_noticia'];
            $obj->orden_noticia=$row['orden_noticia'];
            $obj->img_noticia=$row['img_noticia'];
            $datos[0]=$obj;
            $response->estado = array(
                'codigo' => 200,
                'mensaje' => 'Noticia Obtenida con exito.'
            );
            $response->datos=$datos;
        }else {
            $response->estado = array(
                'codigo' => 400,
                'mensaje' => 'No existe una noticia con esta ID.'
            );
        }
        desconectar($conexion);
    }else {
        $response->estado = array(
            'codigo' => 400,
            'mensaje' => 'No un ID de una noticia'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
?>