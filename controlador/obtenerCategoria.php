<?php
    require("conexion.php");
    $response = new stdClass();
    $datos= [];
    if (!empty($_POST['id'])) {
        $conexion = conectar();
        $resultado = mysqli_query($conexion, 'SELECT * FROM categorias WHERE id_categoria = \'' . $_POST['id'] . '\'');
        $row=mysqli_fetch_array($resultado);
            $obj = new stdClass();
            $obj->id_categoria=$row['id_categoria'];
            $obj->nombre=$row['nombre_categoria'];
            $obj->imagenes[0]=$row['foto_categoria'];
            $datos[0]=$obj;
        desconectar($conexion);
        $response->datos=$datos;
        header('Content-Type: application/json');
        echo json_encode($response);
    }else {
        $datos[0]="No envio un ID de categoria";
       $response->datos=$datos;
       header('Content-Type: application/json');
       echo json_encode($response);
    }
?>