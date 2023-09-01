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
            <h1>PEDIDOS</h1>
        </header>
        <section class="acciones-admin">
            <button class="btn-agregar" id="btn-agregarProd">+ Crear un pedido</button>

            <section class="filtrar">
                <form action="" method="get">
                    <label for="cat">Filtro de estado:</label>
                    <select name="categoria" id="cat">
                        <option value="cat1">Pendiente</option>
                        <option value="cat2">Ingresado</option>
                        <option value="cat3">Rechazado</option>
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
        <section class="contenedor-pedidos" id="ctn-pedidos">

            <article class="pedido-row">
                <section class="ctn-infoprim-pedido">
                    <div class="detalles-pedido">
                        <p class="titulo-pedido">ID pedido:</p>
                        <p>TAZ-4J3K3J43K33H3Y</p>
                    </div>
                    <div class="detalles-pedido">
                        <p class="titulo-pedido">Fecha:</p>
                        <p>29/8/2023-17:16:54</p>
                    </div>
                    <div class="detalles-pedido">
                        <p class="titulo-pedido">Estado:</p>
                        <p>pendiente de ingresar</p>
                    </div>
                </section>
                <section class="ctn-infosec-pedido">
                    <div class="info-pedido">
                        <p class="titulo-infosec">Articulos</p>
                        <p class="infosec"> 2 </p>
                        <p class="infoter">  </p>
                    </div>
                    <div class="info-pedido">
                        <p class="titulo-infosec">Total del pedido</p>
                        <p class="infosec"> $21500 </p>
                        <p class="infoter">  </p>
                    </div>

                    <div class="info-pedido">
                        <p class="titulo-infosec">Medio de pago</p>
                        <p class="infosec"> efectivo </p>
                        <p class="infoter"> pendiente </p>
                    </div>

                    <div class="info-pedido">
                        <p class="titulo-infosec">Met. de entrega</p>
                        <p class="infosec"> envio-domicilio </p>
                        <p class="infoter"> pje. chubut 352 </p>
                    </div>
                </section>
            </article>

        </section>
    </main>

</section>

<section class="contenedormodal" id="modal-eliminarProducto">
    <section class="modal">
        <h3>¿Desea eliminar este producto?</h3>
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

<section class="contenedormodal" id="contenedormodal-crearProducto">
    <section class="modal">
        <section class="contenedor-formnuevoproducto" id="contenedor-formnuevoproducto">
            <h2>CREAR NUEVO PRODUCTO</h2>
            <section class="contenedor-botoncerrar">
                <button id="btn-cerrar"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                    </svg> </button>
            </section>
            <form id="formModal" action="../../controlador/nuevo_producto.php" method="post" enctype="multipart/form-data">
                <section class="form-crear">
                    <section>
                        <div class="input-container">
                            <input id="foto1-reg" type="hidden" name="foto1-reg">
                            <input type="file" id="input-file1" name="foto1">
                            <img id="preview-image1">
                            <a class="remove-image" id="remove-image1">X</a>
                        </div>
                        <div class="input-container">
                            <input id="foto2-reg" type="hidden" name="foto2-reg">
                            <input type="file" id="input-file2" name="foto2">
                            <img id="preview-image2">
                            <a class="remove-image" id="remove-image2">X</a>
                        </div>
                        <div class="input-container">
                            <input id="foto3-reg" type="hidden" name="foto3-reg">
                            <input type="file" id="input-file3" name="foto3">
                            <img id="preview-image3">
                            <a class="remove-image" id="remove-image3">X</a>
                        </div>
                    </section>
                    <input id="idprod" type="hidden" name="idprod">
                    <label for="nomb">Nombre del producto</label>
                    <input type="text" name="nomb" id="nomb" placeholder="Ingrese aqui..." required maxlength="240">
                    <label for="des">Descripcion</label>
                    <textarea name="descripcion" id="des" cols="45" rows="5" placeholder="Ingrese aqui..."></textarea>
                    
                    <section class="cont-select">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <?php
                            $conexion = conectar();
                            $resultado = mysqli_query($conexion, 'SELECT * FROM categorias');
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($fila = mysqli_fetch_array($resultado)) {
                                    echo '<option value="', $fila[0], '">', $fila[1], '</option>';
                                }
                            }
                            desconectar($conexion);
                            ?>
                        </select>
                    </section>

                    <label for="precm">Precio por menor</label>
                    <input type="number" name="precioMenor" id="precm" placeholder="Ingrese aqui..." required min=0>

                    <label class="apple-switch">
                        <input id="checkOferta" type="checkbox" name="checkOferta">
                        <span class="slider"></span>
                        <span class="label-text">¿Esta en oferta?</span>
                    </label>

                    <label for="precm">Precio de oferta</label>
                    <input type="number" name="precioOferta" id="preco" placeholder="Ingrese aqui..." min=0>

                    <label class="apple-switch">
                        <input id="checkDestacado" type="checkbox" name="destacado">
                        <span class="slider"></span>
                        <span class="label-text">¿Destacar el producto?</span>
                    </label>

                    <section class="cont-select">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado">
                            <option value="Activo">Activo</option>
                            <option value="Sin Stock">Sin Stock</option>
                            <option value="Oculto">Oculto</option>
                        </select>
                    </section>
                    <section id="boton">
                        <input type="submit" name="enviar" value="Confirmar">
                    </section>
                </section>
            </form>
        </section>
    </section>
</section>


<?php
echo '<script src="../js/pedidos-page.js"></script>';
require_once("../vista/modulos/footer-admin.php");

?>