<?php
//  TODAVIA NO TERMINE ESTO
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
            header("refresh:0;url=usuario.php");
            exit();
        }
    $ruta = '../css';
    $rutaImg = '../img/noticias/';
    require("conexion.php");
    $bandera = 0;
    setlocale(LC_ALL, 'spanish');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('dmyhisu');
if (!empty($_POST['descripcion']) && !empty('idnot')) {
        $id = trim($_POST['idnot']);
        $descripcion = trim($_POST['descripcion']);
        $orden = trim($_POST['orden']);
        $nombreIMG1='';
        $fotoreg1=$_POST['foto1-reg'];
        if (!empty($_POST['checkActivo'])) {
            $checkActivo = true;
        }else{
            $checkActivo = false;
        }

        $conexion = conectar();
        $respuesta = mysqli_query($conexion, 'SELECT * FROM noticias WHERE id_noticia = \'' . $id . '\'');
        if (mysqli_num_rows($respuesta) > 0) {
            $fila = mysqli_fetch_array($respuesta);       
            $respuestaRepetido = mysqli_query($conexion, 'SELECT * FROM noticias WHERE orden_noticia =\'' . $orden . '\' AND id_noticia != \'' . $id . '\'');
            if (mysqli_num_rows($respuestaRepetido) > 0) {
                $filaRepetido = mysqli_fetch_array($respuestaRepetido);
                $resultado = mysqli_query($conexion, 'UPDATE noticias SET orden_noticia = \''. $fila['orden_noticia'] .'\' WHERE id_noticia =  \''. $filaRepetido['id_noticia'] .'\'');       
                }

            if (!empty($_FILES['foto1']['size'])) {
                $nombreIMG1=GuardarImagen('foto1', $rutaImg);
                if (!empty($fila[4])) {
                    unlink($rutaImg.$fila[4]);
                }
            }else {
                if (empty($fotoreg1) && !empty($fila[4])) {
                    unlink($rutaImg.$fila[4]);
                }else {
                    $nombreIMG1=$fotoreg1;
                }
            }

            $resultado = mysqli_query($conexion, 'UPDATE noticias SET nombre_noticia = \''.$descripcion.'\', img_noticia = \''.$nombreIMG1.'\', orden_noticia = \''.$orden.'\', estado_noticia = \''.$checkActivo.'\'  WHERE id_noticia =  \''.$id.'\'');
            if ($resultado) {
                echo "modifico la categoria de id:" . $id;
            }
        }

        desconectar($conexion);
        header("refresh:0;url=../admin/pages/noticias.php");
    }else {
        echo "no modifico";
        header("refresh:0;url../admin/pages/noticias.php");
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
        $nombreIMG1 = uniqid('NOT-').$imagen.'.webp';
        $rutaFinal = $rutaImg.$nombreIMG1;
        imagewebp($destination, $rutaFinal, 80); // Calidad 80
    
        // Liberar la memoria ocupada por las imágenes en GD
        imagedestroy($source);
        imagedestroy($destination);
        return $nombreIMG1;
    }
        
?>