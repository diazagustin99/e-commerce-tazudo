<?php
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header("refresh:0;url=usuario.php");
            exit();
        }
    $ruta = '../css';
    $rutaImg = '../img/categorias/';
    require("conexion.php");
    $bandera = 0;
    setlocale(LC_ALL, 'spanish');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('dmyhisu');
if (!empty($_POST['nomb'])) {
    $nombreCategoria = trim($_POST['nomb']);
    $nombreIMG1='';


    if (!empty($_FILES['foto1']['size'])) {
        $nombreIMG1=GuardarImagen('foto1', $rutaImg);
    }

    $conexion = conectar();
    $resultado = mysqli_query($conexion, 'INSERT INTO categorias(nombre_categoria, foto_categoria) VALUES (\''.$nombreCategoria.'\', \''.$nombreIMG1.'\')');
    desconectar($conexion);
    header("refresh:0;url=../admin/pages/categorias.php");
    }else {
    header("refresh:0;url=../admin/pages/categorias.php");
    }

    function GuardarImagen($imagen, $rutaImg){
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
        $nombreIMG1 = uniqid('CAT-').$imagen.'.webp';
        $rutaFinal = $rutaImg.$nombreIMG1;
        imagewebp($destination, $rutaFinal, 80); // Calidad 80
    
        // Liberar la memoria ocupada por las imágenes en GD
        imagedestroy($source);
        imagedestroy($destination);
        return $nombreIMG1;
    }
        
?>