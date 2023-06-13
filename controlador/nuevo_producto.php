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
    $nombreProd = trim($_POST['nomb']);
    $descripcion = trim($_POST['descripcion']);
    $categoria = trim($_POST['categoria']);
    $precioMenor = trim($_POST['precioMenor']);
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
    $precioOferta = trim($_POST['precioOferta']);
    $estado = trim($_POST['estado']);
    $nombreIMG1='';
    $nombreIMG2='';
    $nombreIMG3='';

    if (!empty($_FILES['foto1']['size'])) {
        $nombreIMG1=GuardarImagen('foto1',$rutaImg,$nombreProd);
    }

        if (!empty($_FILES['foto2']['size'])) {
        $nombreIMG2=GuardarImagen('foto2',$rutaImg,$nombreProd);    
    }

        if (!empty($_FILES['foto3']['size'])) {
        $nombreIMG3=GuardarImagen('foto3',$rutaImg,$nombreProd);
    }

    $conexion = conectar();
    $resultado = mysqli_query($conexion, 'INSERT INTO productos(nombre, descripcion, precio_menor, categoria, foto1, foto2, foto3, estado_oferta, precio_oferta, estado, destacado) VALUES (\''.$nombreProd.'\', \''.$descripcion.'\', \''. $precioMenor .'\', \''. $categoria .'\', \''.$nombreIMG1.'\', \''.$nombreIMG2.'\', \''.$nombreIMG3.'\', \''.$checkOferta.'\', \''.$precioOferta.'\', \''.$estado.'\', \''.$checkDestacado.'\' )');
    desconectar($conexion);
    header("refresh:0;url=../admin/pages/productos.php");
    }else {
    header("refresh:0;url=../admin/pages/productos.php");
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