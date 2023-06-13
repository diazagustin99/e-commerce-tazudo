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
        $id = trim($_POST['idcat']);
        $nombreCat = trim($_POST['nomb']);
        $nombreIMG1='';
        $fotoreg1=$_POST['foto1-reg'];


        $conexion = conectar();
        $respuesta = mysqli_query($conexion, 'SELECT foto_categoria FROM categorias WHERE id_categoria = \'' . $id . '\'');
        if (mysqli_num_rows($respuesta) > 0) {
        $fila = mysqli_fetch_array($respuesta);       
        }

        if (!empty($_FILES['foto1']['size'])) {
            $nombreIMG1=GuardarImagen('foto1', $rutaImg);
            if (!empty($fila[0])) {
                unlink($rutaImg.$fila[0]);
            }
        }else {
            if (empty($fotoreg1) && !empty($fila[0])) {
                unlink($rutaImg.$fila[0]);
            }else {
                $nombreIMG1=$fotoreg1;
            }
        }

        $resultado = mysqli_query($conexion, 'UPDATE categorias SET nombre_categoria = \''.$nombreCat.'\', foto_categoria = \''.$nombreIMG1.'\' WHERE id_categoria =  \''.$id.'\'');
        if ($resultado) {
            echo "modifico la categoria de id:" . $id;
        }
        desconectar($conexion);
        header("refresh:0;url=../admin/pages/categorias.php");
    }else {
        echo "no modifico";
        header("refresh:0;url../admin/pages/categorias.php");
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