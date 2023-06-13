<?php
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header("refresh:0;url=usuario.php");
            exit();
        }
    $ruta = '../css';
    $rutaImg = '../img/productos/';
    require("conexion.php");
    $bandera = 0;
    setlocale(LC_ALL, 'spanish');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('dmyhisu');
if (!empty($_POST['nomb']) && !empty($_POST['descripcion']) && !empty($_POST['categoria']) && !empty($_POST['precioMenor'])) {
        $id = trim($_POST['idprod']);
        $nombreProd = trim($_POST['nomb']);
        $descripcion = trim($_POST['descripcion']);
        $categoria = trim($_POST['categoria']);
        $precioMenor = trim($_POST['precioMenor']);
        $precioOferta = trim($_POST['precioOferta']);
        $estado = trim($_POST['estado']);

        if (!empty($_POST['checkOferta'])) {
            $checkOferta = true;
        }else{
            $checkOferta = false;
        }
        if (!empty($_POST['destacado'])) {
            $checkDestacado = true;
        }else{
            $checkDestacado = false;
        }

        $nombreIMG1='';
        $nombreIMG2='';
        $nombreIMG3='';
        $fotoreg1=trim($_POST['foto1-reg']);
        $fotoreg2=trim($_POST['foto2-reg']);
        $fotoreg3=trim($_POST['foto3-reg']);

        $conexion = conectar();
        $respuesta = mysqli_query($conexion, 'SELECT foto1, foto2, foto3 FROM productos WHERE id_producto = \'' . $id . '\'');
        if (mysqli_num_rows($respuesta) > 0) {
        $fila = mysqli_fetch_array($respuesta);       
        }

        if (!empty($_FILES['foto1']['size'])) {
            $nombreIMG1=GuardarImagen('foto1',$rutaImg,$nombreProd);  
            if (!empty($fila[0])) {
                unlink($rutaImg.$fila[0]);
            }
        }else {
            if (empty($fotoreg1)  && !empty($fila[0])) {
                unlink($rutaImg.$fila[0]);
            }else {
                $nombreIMG1=$fotoreg1;
            }
        }


        if (!empty($_FILES['foto2']['size'])) {
            $nombreIMG2=GuardarImagen('foto2',$rutaImg,$nombreProd);  
            if (!empty($fila[1])) {
                unlink($rutaImg.$fila[1]);
            }
        }else {
            if (empty($fotoreg2)   && !empty($fila[1])) {
                unlink($rutaImg.$fila[1]);
            }else {
                $nombreIMG2=$fotoreg2;
            }
        }

        if (!empty($_FILES['foto3']['size'])) {
            $nombreIMG3=GuardarImagen('foto3',$rutaImg,$nombreProd); 
            if (!empty($fila[2])) {
                unlink($rutaImg.$fila[2]);
            }
        }else {
            if (empty($fotoreg3)  && !empty($fila[2])) {
                unlink($rutaImg.$fila[2]);
                echo 'entro donde debe eliminar si se elimino la foto';
            }else {
                $nombreIMG3=$fotoreg3;
            }
        }

        $resultado = mysqli_query($conexion, 'UPDATE productos SET nombre = \''.$nombreProd.'\', descripcion = \''.$descripcion.'\', precio_menor = \''. $precioMenor .'\', categoria = \''. $categoria .'\', foto1 = \''.$nombreIMG1.'\', foto2 = \''.$nombreIMG2.'\', foto3 = \''.$nombreIMG3.'\', estado_oferta = \''.$checkOferta.'\', precio_oferta = \''.$precioOferta.'\', estado = \''.$estado.'\', destacado = \''.$checkDestacado.'\' WHERE id_producto =  \''.$id.'\'');

        desconectar($conexion);
        echo $fotoreg1 . "//////" . $fotoreg2 . "------". $fotoreg3 . "//////";
        echo $fila[0] . "%%%%%%" . $fila[1] . '++++++' . $fila[2] . "%%%%%%";
        header("refresh:0;url=../admin/pages/productos.php");
    }else {
        echo "no modifico";
        header("refresh:0.5;url=../admin/pages/productos.php");
    }


    function GuardarImagen($imagen, $rutaImg,$nombreProd){
        $tmp_name = $_FILES[$imagen]['tmp_name'];

        // Obtener información de la imagen
        $image_info = getimagesize($tmp_name);
        $width = $image_info[0];
        $height = $image_info[1];
    
        // Crear una imagen en GD desde la imagen cargada
        if ($image_info['mime'] === 'image/jpeg') {
          $source = imagecreatefromjpeg($tmp_name);
        } elseif ($image_info['mime'] === 'image/png') {
          $source = imagecreatefrompng($tmp_name);
        } elseif ($image_info['mime'] === 'image/gif') {
          $source = imagecreatefromgif($tmp_name);
        } else {
          // La imagen no es compatible con GD
          echo "El formato de imagen no es compatible con GD.";
          exit();
        }
    
        // Crear una nueva imagen vacía en GD con formato WebP
        $destination = imagecreatetruecolor($width, $height);
    
        // Copiar la imagen original en la imagen vacía
        imagecopy($destination, $source, 0, 0, 0, 0, $width, $height);
    
        // Guardar la imagen en formato WebP
        $nombreIMG1 = uniqid('TAZ-').$imagen.'.webp';
        $rutaFinal = $rutaImg.$nombreIMG1;

        imagewebp($destination, $rutaFinal, 80); // Calidad 80
    
        // Liberar la memoria ocupada por las imágenes en GD
        imagedestroy($source);
        imagedestroy($destination);
        return $nombreIMG1;
    }
        
?>