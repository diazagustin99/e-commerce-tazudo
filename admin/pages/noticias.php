<?php
session_start();
if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header("refresh:0;url=../index.php");
    exit();
}
$ruta = '../../css';
require_once("../vista/modulos/header-admin.php");
require_once("../../controlador/conexion.php");
?>
<section class="aside-main">
    <?php require("../vista/modulos/menu-admin.php"); ?>
    <main>
        <header>
            <h1>NOTICIAS</h1>
        </header>
        <section class="acciones-admin">
            <button class="btn-agregar" id="btn-agregarnot">+ Agregar NOTICIA</button>

            <section class="filtrar">
                <form action="" method="get">
                    <label for="estadoNot">Filtro de estado:</label>
                    <select name="estadoNot" id="estadoNot">
                        <option value="ON">NOTICIAS ACTIVAS</option>
                        <option value="OFF">NOTICIAS OFF</option>
                    </select>
                    <button type="submit" class="btn-filtrar"> Filtrar</button>
                </form>
            </section>

            <section class="filtrar busqueda">
                <form action="" method="get">
                    <label for="nombre">Busqueda por nombre</label>
                    <input type="text" name="nombre" id="nombre">
                    <button type="submit" class="btn-filtrar"> Buscar </button>
                </form>
            </section>

        </section>
        <section class="contenedor-tabla-prods">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>
                            CODIGO
                        </th>
                        <th>
                            FOTO
                        </th>
                        <th>
                            NOMBRE NOTICIA
                        </th>
                        <th>
                            ESTADO
                        </th>
                        <th>
                            ORDEN
                        </th>
                        <th>
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conexion = conectar();
                    $resultado = mysqli_query($conexion, 'SELECT * FROM noticias');
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($fila = mysqli_fetch_array($resultado)) {
                            if ($fila[2] == 0) {
                                $estadoOferta = 'OFF';
                            } else {
                                $estadoOferta = 'ON';
                            }

                            echo '<tr>';

                            echo '<td>', $fila[0], '</td>';
                            echo '<td class="td-prod">', '<figure><img src="', '../../img/noticias/' . $fila[4], '" alt="foto de la noticia ', $fila[1], '"></figure></td>';
                            echo '<td><p>', $fila[1], '</p></td>';
                            echo '<td>', $estadoOferta, '</td>';
                            echo '<td class="p-estado">', $fila[3], '</td>';
                            echo '<td class="contenedor-acciones">', '
                                <a  class="btn-accion btn-editar" id="' . $fila[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg></a>',
                            '<a class="btn-accion btn-eliminar" id="' . $fila[0] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg></a>', '</td>';

                            echo '</tr>';
                        }
                    }
                    desconectar($conexion);
                    ?>

                </tbody>
            </table>
        </section>
    </main>

</section>

<section class="contenedormodal" id="modal-eliminarNoticia">
    <section class="modal">
        <h3>¿Desea eliminar esta noticia?</h3>
        <section class="card-prod-elim">
            <figure>
                <img id="img-prod-card-eliminar" src="" alt="">
            </figure>
            <h3 id="nomb-prod-card-eliminar">Producto Nombre</h3>
            <p id="precio-prod-card-eliminar">$5999</p>

        </section>
        <section class="contenedor-opcionesEliminar">
            <a href="" id="btn-eliminar-conf">Eliminar</a>
            <a id="btn-eliminar-cancelar">Cancelar</a>
        </section>
    </section>
</section>

<section class="contenedormodal" id="contenedormodal-crearNoticia">
    <section class="modal">
        <section class="contenedor-formNoticia" id="contenedor-formNoticia">
            <h2>CREAR NUEVA NOTICIA</h2>
            <section class="contenedor-botoncerrar">
                <button id="btn-cerrar"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg> </button>
            </section>
            <form id="formModal" action="../../controlador/nueva_noticia.php" method="post" enctype="multipart/form-data">
                <section class="form-crear">
                    <section>
                        <div class="input-container-noticia">
                            <input id="foto1-reg" type="hidden" name="foto1-reg">
                            <input type="file" id="input-file1" name="foto1">
                            <img id="preview-image1">
                            <a class="remove-image" id="remove-image1">X</a>
                        </div>
                    </section>
                    <input id="idnot" type="hidden" name="idnot">
                    <label for="des">Descripcion de la noticia</label>
                    <textarea name="descripcion" id="des" cols="45" rows="5" placeholder="Ingrese aqui..."></textarea>
                    
                    <section class="cont-select">
                        <label for="orden">orden</label>
                        <select name="orden" id="orden">
                            <?php
                            $conexion = conectar();
                            $resultado = mysqli_query($conexion, 'SELECT * FROM noticias WHERE estado_noticia = 1');
                            $count = 1;
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($fila = mysqli_fetch_array($resultado)) {
                                    echo '<option value="', $count, '">Posicion: ', $count, '</option>';
                                    $count++;
                                }
                                echo '<option value="', $count, '" selected>Posicion: ', $count, '</option>';
                            }else {
                                echo '<option value="', '1', '">', 'Posicion: 1', '</option>';
                            }
                            desconectar($conexion);
                            ?>
                        </select>

                    </section>

                    <label class="apple-switch">
                        <input id="checkActivo" type="checkbox" name="checkActivo">
                        <span class="slider"></span>
                        <span class="label-text">¿Activar la noticia?</span>
                    </label>
                    <section id="boton">
                        <input type="submit" name="enviar" value="Confirmar">
                    </section>
                </section>
            </form>
        </section>
    </section>
</section>


<?php
echo '<script src="../js/modal-CMnoticias.js"></script>';
echo '<script src="../js/modal-eliminarNoticia.js"></script>';
require_once("../vista/modulos/footer-admin.php");
?>